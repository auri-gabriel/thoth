<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Models\SelectionStatus;
use Models\QAStatus;
use Models\ExtractionStatus;

/**
 * Trait Project_Model_Papers
 *
 * This trait provides all logic for handling papers in a systematic review project.
 * It covers selection, quality assessment (QA), extraction, bib resolution, paper counts,
 * reviewer statistics, and bib export. All status codes use PHP 8.1+ enums for clarity and safety.
 *
 * Key concepts:
 * - Bib: Bibliographic record, imported from external databases.
 * - Paper: Individual study/article, linked to a bib.
 * - Member: Project participant (admin, reviewer, etc).
 * - Status: Enum value representing selection, QA, or extraction state.
 *
 * All methods are type-hinted and documented for maintainability.
 */
trait Project_Model_Papers
{
	// =========================================================================
	// Private — Bib / paper ID resolution
	// =========================================================================

	/**
	 * Get the number of bib records for a given database and project.
	 *
	 * @param string $database Name of the database (e.g., 'Scopus').
	 * @param int $id_project Project ID.
	 * @return int Number of bib records imported for this database in the project.
	 */
	public function get_num_bib(string $database, int $id_project): int
	{
		$id_database         = $this->get_id_database($database);
		$id_project_database = $this->get_id_project_database($id_database, $id_project);

		$this->db->where('id_project_database', $id_project_database);
		$this->db->from('bib_upload');
		return $this->db->count_all_results();
	}

	/**
	 * Resolves the chain project → project_databases → bibs.
	 * Returns an empty array at each step if nothing is found.
	 */
	/**
	 * Resolve all bib IDs for a project.
	 *
	 * Follows the chain: project → project_databases → bibs.
	 * Returns an empty array if any step is missing.
	 *
	 * @param int $id_project Project ID.
	 * @return array Bib IDs for the project.
	 */
	private function resolve_bib_ids(int $id_project): array
	{
		$ids_project_database = $this->get_ids_project_database($id_project);
		if (empty($ids_project_database)) {
			return [];
		}
		return $this->get_ids_bibs($ids_project_database);
	}

	// =========================================================================
	// Private — Paper loaders
	// =========================================================================

	/**
	 * Get all papers for a project, including their selection status for the current user.
	 *
	 * Loads selection status for each paper for the current member, then loads paper metadata.
	 *
	 * @param int $id_project Project ID.
	 * @return array List of Paper objects with selection status set if available.
	 */
	public function get_papers_selection(int $id_project): array
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$id_user   = $this->get_id_name_user($this->session->email);
		$id_member = $this->get_id_member($id_user[0], $id_project);

		// Load all selection statuses for this member in one query
		$this->db->select('id_paper, id_status');
		$this->db->from('papers_selection');
		$this->db->where('id_member', $id_member);

		$statuses = [];
		foreach ($this->db->get()->result() as $row) {
			$statuses[$row->id_paper] = $row->id_status;
		}

		$this->db->select('papers.title, papers.id, papers.id_paper, papers.author, papers.year, data_base.name');
		$this->db->from('papers');
		$this->db->join('data_base', 'papers.data_base = data_base.id_database');
		$this->db->where_in('id_bib', $id_bibs);

		$papers = [];
		foreach ($this->db->get()->result() as $row) {
			$p = new Paper();
			$p->set_id($row->id);
			$p->set_title($row->title);
			$p->set_author($row->author);
			$p->set_database($row->name);
			$p->set_year($row->year);

			if (isset($statuses[$row->id_paper])) {
				$p->set_status_selection($statuses[$row->id_paper]);
			}

			$papers[] = $p;
		}
		return $papers;
	}

	/**
	 * Loads QA papers for a given project, applying an optional status filter on papers.status_qa.
	 *
	 * @param int|array|null $status_qa_filter  Pass null for member-view (uses papers_qa join),
	 *                                           an int or array for a direct status_qa WHERE filter.
	 * @param bool           $member_view        When true, uses session user's member record for per-member status.
	 */
	/**
	 * Load QA papers for a project, optionally filtering by QA status.
	 *
	 * If $member_view is true, loads per-member QA status from papers_qa table.
	 * Otherwise, loads global QA status from papers table.
	 *
	 * @param int $id_project Project ID.
	 * @param int|array|null $status_qa_filter Filter by QA status (int or array of ints), or null for all.
	 * @param bool $member_view If true, loads per-member QA status.
	 * @return array List of Paper objects with QA status and score.
	 */
	private function load_papers_qa(int $id_project, int|array|null $status_qa_filter = null, bool $member_view = false): array
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$id_member = null;
		if ($member_view) {
			$id_user   = $this->get_id_name_user($this->session->email);
			$id_member = $this->get_id_member($id_user[0], $id_project);
		}

		$this->db->select('papers.title, papers.id, papers.id_paper, papers.author, papers.year, data_base.name, papers.status_qa, papers.score, papers.id_gen_score');
		$this->db->from('papers');
		$this->db->join('data_base', 'papers.data_base = data_base.id_database');
		$this->db->where_in('id_bib', $id_bibs);
		$this->db->where('status_selection', SelectionStatus::Accepted->value);

		if ($status_qa_filter !== null) {
			if (is_array($status_qa_filter)) {
				$this->db->where_in('status_qa', $status_qa_filter);
			} else {
				$this->db->where('status_qa', $status_qa_filter);
			}
		}

		$paper_rows = $this->db->get()->result();

		// Fetch per-member QA data in one query when in member view
		$member_qa = [];
		if ($member_view && $id_member !== null && !empty($paper_rows)) {
			$this->db->select('id_paper, id_status, id_gen_score, score');
			$this->db->from('papers_qa');
			$this->db->where('id_member', $id_member);
			foreach ($this->db->get()->result() as $r) {
				$member_qa[$r->id_paper] = $r;
			}
		}

		// Collect all gen_score IDs to fetch descriptions in one query
		$gen_score_ids = array_filter(array_unique(array_map(
			fn($r) => $member_view && isset($member_qa[$r->id_paper])
				? $member_qa[$r->id_paper]->id_gen_score
				: $r->id_gen_score,
			$paper_rows
		)));

		$score_descriptions = [];
		if (!empty($gen_score_ids)) {
			$this->db->select('id_general_score, description');
			$this->db->from('general_score');
			$this->db->where_in('id_general_score', $gen_score_ids);
			foreach ($this->db->get()->result() as $r) {
				$score_descriptions[$r->id_general_score] = $r->description;
			}
		}

		$papers = [];
		foreach ($paper_rows as $row) {
			$p = new Paper();
			$p->set_id($row->id);
			$p->set_title($row->title);
			$p->set_author($row->author);
			$p->set_database($row->name);
			$p->set_year($row->year);

			if ($member_view && isset($member_qa[$row->id_paper])) {
				$qa = $member_qa[$row->id_paper];
				$p->set_status_quality($qa->id_status);
				$p->set_score($qa->score);
				$gen_score_id = $qa->id_gen_score;
			} else {
				$p->set_status_quality($row->status_qa);
				$p->set_score($row->score);
				$gen_score_id = $row->id_gen_score;
			}

			if (isset($score_descriptions[$gen_score_id])) {
				$p->set_rule_quality($score_descriptions[$gen_score_id]);
			}

			$papers[] = $p;
		}
		return $papers;
	}

	/**
	 * Get QA papers for the current member in a project.
	 *
	 * @param int $id_project Project ID.
	 * @return array List of Paper objects with per-member QA status.
	 */
	public function get_papers_qa(int $id_project): array
	{
		return $this->load_papers_qa($id_project, null, true);
	}

	/**
	 * Get QA papers for a project, filtered to only accepted papers (for LaTeX export).
	 *
	 * @param int $id_project Project ID.
	 * @return array List of accepted Paper objects.
	 */
	public function get_papers_qa_latex(int $id_project): array
	{
		return $this->load_papers_qa($id_project, QAStatus::Accepted->value, false);
	}

	/**
	 * Get QA papers for a project, filtered to accepted and rejected papers (for visitor view).
	 *
	 * @param int $id_project Project ID.
	 * @return array List of accepted/rejected Paper objects.
	 */
	public function get_papers_qa_visitor(int $id_project): array
	{
		return $this->load_papers_qa($id_project, [QAStatus::Accepted->value, QAStatus::Rejected->value], false);
	}

	/**
	 * Get papers for extraction step, filtered to those accepted in QA.
	 *
	 * @param int $id_project Project ID.
	 * @return array List of Paper objects for extraction.
	 */
	public function get_papers_ex(int $id_project): array
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('papers.title, papers.id, papers.id_paper, papers.author, papers.year, data_base.name, papers.status_extraction');
		$this->db->from('papers');
		$this->db->join('data_base', 'papers.data_base = data_base.id_database');
		$this->db->where_in('id_bib', $id_bibs);
		$this->db->where('status_qa', QAStatus::Accepted->value);

		$papers = [];
		foreach ($this->db->get()->result() as $row) {
			$p = new Paper();
			$p->set_id($row->id);
			$p->set_title($row->title);
			$p->set_author($row->author);
			$p->set_database($row->name);
			$p->set_year($row->year);
			$p->set_status_extraction($row->status_extraction);
			$papers[] = $p;
		}
		return $papers;
	}

	// =========================================================================
	// Public — Paper counts
	// =========================================================================

	/**
	 * Get the number of papers per database for a project.
	 *
	 * @param int $id_project Project ID.
	 * @return array [database name => paper count]
	 */
	public function get_num_papers(int $id_project): array
	{
		$data = [];
		foreach ($this->get_databases($id_project) as $database) {
			$id_database         = $this->get_id_database($database->get_name());
			$id_project_database = $this->get_id_project_database($id_database, $id_project);
			$id_bib              = $this->get_ids_bibs($id_project_database);

			if (!empty($id_bib)) {
				$this->db->where_in('id_bib', $id_bib);
				$this->db->from('papers');
				$data[$database->get_name()] = $this->db->count_all_results();
			} else {
				$data[$database->get_name()] = 0;
			}
		}
		return $data;
	}

	/**
	 * Get the names of all bibs per database for a project.
	 *
	 * @param int $id_project Project ID.
	 * @return array [database name => array of bib names]
	 */
	public function get_name_bibs(int $id_project): array
	{
		$data = [];
		foreach ($this->get_databases($id_project) as $database) {
			$id_database         = $this->get_id_database($database->get_name());
			$id_project_database = $this->get_id_project_database($id_database, $id_project);

			$this->db->select('name');
			$this->db->from('bib_upload');
			$this->db->where('id_project_database', $id_project_database);

			$data[$database->get_name()] = array_column($this->db->get()->result(), 'name');
		}
		return $data;
	}

	/**
	 * Count papers by selection status for a project.
	 *
	 * Returns an array keyed by SelectionStatus enum values (int), plus key 6 for total.
	 *
	 * @param int $id_project Project ID.
	 * @return array [status => count, 6 => total]
	 */
	public function count_papers_by_status_sel(int $id_project): array
	{
		$cont  = [
			SelectionStatus::Accepted->value     => 0,
			SelectionStatus::Rejected->value     => 0,
			SelectionStatus::Unclassified->value => 0,
			SelectionStatus::Duplicate->value    => 0,
			SelectionStatus::Removed->value      => 0,
			6 => 0
		];
		$total = 0;

		$id_bibs = $this->resolve_bib_ids($id_project);
		if (!empty($id_bibs)) {
			$this->db->select('status_selection, COUNT(*) as count');
			$this->db->from('papers');
			$this->db->group_by('status_selection');
			$this->db->where_in('id_bib', $id_bibs);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->status_selection] = $row->count;
				$total += $row->count;
			}
		}
		$cont[6] = $total;
		return $cont;
	}

	/**
	 * Count papers by QA status for a project.
	 *
	 * Returns an array keyed by QAStatus enum values (int), with total in QAStatus::Removed.
	 *
	 * @param int $id_project Project ID.
	 * @return array [status => count]
	 */
	public function count_papers_by_status_qa(int $id_project): array
	{
		$cont  = [
			QAStatus::Accepted->value     => 0,
			QAStatus::Rejected->value     => 0,
			QAStatus::Unclassified->value => 0,
			QAStatus::Duplicate->value    => 0,
			QAStatus::Removed->value      => 0
		];
		$total = 0;

		$id_bibs = $this->resolve_bib_ids($id_project);
		if (!empty($id_bibs)) {
			$this->db->select('status_qa, COUNT(*) as count');
			$this->db->from('papers');
			$this->db->group_by('status_qa');
			$this->db->where_in('id_bib', $id_bibs);
			$this->db->where('status_selection', SelectionStatus::Accepted->value);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->status_qa] = $row->count;
				$total += $row->count;
			}
		}
		$cont[QAStatus::Removed->value] = $total;
		return $cont;
	}

	/**
	 * Count papers by extraction status for a project.
	 *
	 * Returns an array keyed by ExtractionStatus enum values (int), with total in ExtractionStatus::Duplicate.
	 *
	 * @param int $id_project Project ID.
	 * @return array [status => count]
	 */
	public function count_papers_extraction(int $id_project): array
	{
		$cont  = [
			ExtractionStatus::Accepted->value     => 0,
			ExtractionStatus::Rejected->value     => 0,
			ExtractionStatus::Unclassified->value => 0,
			ExtractionStatus::Duplicate->value    => 0
		];
		$total = 0;

		$id_bibs   = $this->resolve_bib_ids($id_project);
		$id_papers = !empty($id_bibs) ? $this->get_ids_papers_ex($id_bibs) : [];

		if (!empty($id_papers)) {
			$this->db->select('status_extraction, COUNT(*) as count');
			$this->db->from('papers');
			$this->db->group_by('status_extraction');
			$this->db->where_in('id_paper', $id_papers);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->status_extraction] = $row->count;
				$total += $row->count;
			}
			$cont[ExtractionStatus::Duplicate->value] = $total;
		}
		return $cont;
	}

    // =========================================================================
    // Public — Reviewer stats
    // =========================================================================

	/**
	 * Counts paper statuses per reviewer member for a given table.
	 *
	 * @param string $id_papers_getter  Method name on $this to get paper IDs from bib IDs.
	 * @param int    $total_key         Array key to store the total count.
	 */
	/**
	 * Count paper statuses per reviewer member for a given table.
	 *
	 * Used for both selection and QA reviewer stats.
	 * Only includes admins and reviewers (level 1 and 3).
	 *
	 * @param int $id_project Project ID.
	 * @param string $table Table name ('papers_selection' or 'papers_qa').
	 * @param string $id_papers_getter Method name to get paper IDs.
	 * @param int $total_key Array key to store total count.
	 * @return array [email => [status => count, ...]]
	 */
	private function count_papers_reviewer_generic(int $id_project, string $table, string $id_papers_getter, int $total_key): array
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$id_papers = $this->$id_papers_getter($id_bibs);
		if (empty($id_papers)) {
			return [];
		}

		$data = [];
		foreach ($this->get_members($id_project) as $mem) {
			$level = $this->get_level($mem->get_email(), $id_project);
			// LEVEL_ADMIN = 1, LEVEL_REVIEWER = 3 (from Project_Model.php)
			if ($level != 1 && $level != 3) {
				continue;
			}

			$id_user   = $this->get_id_name_user($mem->get_email());
			$id_member = $this->get_id_member($id_user[0], $id_project);

			$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
			$total = 0;

			$this->db->select('id_status, COUNT(*) as count');
			$this->db->from($table);
			$this->db->group_by('id_status');
			$this->db->where('id_member', $id_member);
			$this->db->where_in('id_paper', $id_papers);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->id_status] = $row->count;
				$total += $row->count;
			}

			$cont[$total_key]        = $total;
			$data[$mem->get_email()] = $cont;
		}
		return $data;
	}

	/**
	 * Count selection statuses per reviewer for a project.
	 *
	 * @param int $id_project Project ID.
	 * @return array [email => [status => count, ...]]
	 */
	public function count_papers_reviewer(int $id_project): array
	{
		return $this->count_papers_reviewer_generic($id_project, 'papers_selection', 'get_ids_papers', 6);
	}

	/**
	 * Count QA statuses per reviewer for a project.
	 *
	 * @param int $id_project Project ID.
	 * @return array [email => [status => count, ...]]
	 */
	public function count_papers_reviewer_qa(int $id_project): array
	{
		return $this->count_papers_reviewer_generic($id_project, 'papers_qa', 'get_ids_papers_qa', 5);
	}

	/**
	 * Counts the number of papers selected by the current user for a given project,
	 * grouped by their selection status.
	 *
	 * The method returns an associative array where the keys (1-5) represent different
	 * selection statuses and the values are the counts of papers for each status.
	 * The key 6 contains the total count of papers selected by the user.
	 *
	 * @param int $id_project The ID of the project for which to count selected papers.
	 * @return array An array with counts of papers per selection status and the total count.
	 *
	 * Status keys:
	 *   1 => Count of papers with status 1
	 *   2 => Count of papers with status 2
	 *   3 => Count of papers with status 3
	 *   4 => Count of papers with status 4
	 *   5 => Count of papers with status 5
	 *   6 => Total count of papers selected by the user
	 */
	/**
	 * Count the number of papers selected by the current user for a project, grouped by selection status.
	 *
	 * Returns an array keyed by status (1-5), plus key 6 for total.
	 *
	 * @param int $id_project Project ID.
	 * @return array [status => count, 6 => total]
	 */
	public function count_papers_sel_by_user(int $id_project): array
	{
		$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
		$total = 0;

		$id_bibs   = $this->resolve_bib_ids($id_project);
		$id_papers = !empty($id_bibs) ? $this->get_ids_papers($id_bibs) : [];

		if (!empty($id_papers)) {
			$id_user   = $this->get_id_name_user($this->session->email);
			$id_member = $this->get_id_member($id_user[0], $id_project);

			$this->db->select('id_status, COUNT(*) as count');
			$this->db->from('papers_selection');
			$this->db->group_by('id_status');
			$this->db->where('id_member', $id_member);
			$this->db->where_in('id_paper', $id_papers);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->id_status] = $row->count;
				$total += $row->count;
			}
			$cont[6] = $total;
		}
		return $cont;
	}

	/**
	 * Count the number of papers QA'd by the current user for a project, grouped by QA status.
	 *
	 * Returns an array keyed by status (1-5), plus key 5 for total.
	 *
	 * @param int $id_project Project ID.
	 * @return array [status => count, 5 => total]
	 */
	public function count_papers_qa_by_user(int $id_project): array
	{
		$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
		$total = 0;

		$id_bibs   = $this->resolve_bib_ids($id_project);
		$id_papers = !empty($id_bibs) ? $this->get_ids_papers_qa($id_bibs) : [];

		if (!empty($id_papers)) {
			$id_user   = $this->get_id_name_user($this->session->email);
			$id_member = $this->get_id_member($id_user[0], $id_project);

			$this->db->select('id_status, COUNT(*) as count');
			$this->db->from('papers_qa');
			$this->db->group_by('id_status');
			$this->db->where('id_member', $id_member);
			$this->db->where_in('id_paper', $id_papers);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->id_status] = $row->count;
				$total += $row->count;
			}
			$cont[5] = $total;
		}
		return $cont;
	}

	// =========================================================================
	// Public — Bib export
	// =========================================================================

	/**
	 * Export bib records for a project, filtered by step (Extraction, Quality, Selection).
	 *
	 * Only papers accepted in the given step are exported.
	 *
	 * @param int $id_project Project ID.
	 * @param string $steps Step name ('Extraction', 'Quality', 'Selection').
	 * @return array List of Paper objects for export.
	 */
	public function export_bib(int $id_project, string $steps): array
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('id, title, author, year, book_title, volume, pages, num_pages, keywords, doi, journal, issn, location, isbn, address, type, bib_key, url, publisher');
		$this->db->from('papers');
		$this->db->where_in('id_bib', $id_bibs);

		switch ($steps) {
			case 'Extraction':
				$this->db->where('status_extraction', ExtractionStatus::Accepted->value);
				break;
			case 'Quality':
				$this->db->where('status_qa', QAStatus::Accepted->value);
				break;
			case 'Selection':
				$this->db->where('status_selection', SelectionStatus::Accepted->value);
				break;
		}

		$papers = [];
		foreach ($this->db->get()->result() as $row) {
			$p = new Paper();
			$p->set_id($row->id);
			$p->set_title($row->title);
			$p->set_author($row->author);
			$p->set_year($row->year);
			$p->set_address($row->address);
			$p->set_bib_key($row->bib_key);
			$p->set_doi($row->doi);
			$p->set_isbn($row->isbn);
			$p->set_issn($row->issn);
			$p->set_journal($row->journal);
			$p->set_num_pages($row->num_pages);
			$p->set_pages($row->pages);
			$p->set_volume($row->volume);
			$p->set_location($row->location);
			$p->set_type($row->type);
			$p->set_book_title($row->book_title);
			$p->set_url($row->url);
			$p->set_publisher($row->publisher);
			$p->set_keywords($row->keywords);
			$papers[] = $p;
		}
		return $papers;
	}
}
