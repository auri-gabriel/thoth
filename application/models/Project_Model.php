<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/Pattern_Model.php';

class Project_Model extends Pattern_Model
{
	// =========================================================================
	// Constants — Paper / member status codes
	// =========================================================================

	const STATUS_ACCEPTED     = 1;
	const STATUS_REJECTED     = 2;
	const STATUS_UNCLASSIFIED = 3;
	const STATUS_DUPLICATE    = 4;
	const STATUS_REMOVED      = 5;

	const LEVEL_ADMIN    = 1;
	const LEVEL_REVIEWER = 3;

	// =========================================================================
	// Private Helpers — Project Hydration & Progress
	// =========================================================================

	/**
	 * Fetches the project row and hydrates only the fields you request.
	 *
	 * Always sets: id, title
	 * Optional fields: 'planning', 'import', 'selection', 'quality',
	 *                  'extraction', 'description', 'objectives',
	 *                  'start_date', 'end_date'
	 */
	private function fetch_base_project($id_project, array $fields = [])
	{
		$project = new Project();

		$this->db->select('project.*');
		$this->db->from('project');
		$this->db->where('id_project', $id_project);
		$row = $this->db->get()->row();

		if (!$row) {
			return $project;
		}

		$project->set_id($row->id_project);
		$project->set_title($row->title);

		$field_map = [
			'planning'    => fn() => $project->set_planning($row->planning),
			'import'      => fn() => $project->set_import($row->import),
			'selection'   => fn() => $project->set_selection($row->selection),
			'quality'     => fn() => $project->set_quality($row->quality),
			'extraction'  => fn() => $project->set_extraction($row->extraction),
			'description' => fn() => $project->set_description($row->description),
			'objectives'  => fn() => $project->set_objectives($row->objectives),
			'start_date'  => fn() => $project->set_start_date($row->start_date),
			'end_date'    => fn() => $project->set_end_date($row->end_date),
		];

		foreach ($fields as $field) {
			if (isset($field_map[$field])) {
				($field_map[$field])();
			}
		}

		return $project;
	}

	/**
	 * Runs update_progress_* calls in pipeline order, stopping at $last_stage.
	 *
	 * Stage order: planning → import → selection → quality → extraction
	 */
	private function update_progress_up_to($id_project, $last_stage)
	{
		$stages = ['planning', 'import', 'selection', 'quality', 'extraction'];
		$errors = [];

		foreach ($stages as $stage) {
			$errors = array_merge($errors, $this->{"update_progress_{$stage}"}($id_project));
			if ($stage === $last_stage) {
				break;
			}
		}

		return $errors;
	}

	// =========================================================================
	// Public — get_project_* methods
	// =========================================================================

	public function get_project_import($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning']);
		$project->set_errors($this->update_progress_up_to($id_project, 'planning'));
		$project->set_databases($this->get_databases($id_project));

		return $project;
	}

	public function get_project_reviewer_selection($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import']);
		$project->set_errors($this->update_progress_up_to($id_project, 'import'));
		$project->set_members($this->get_members($id_project));

		return $project;
	}

	public function get_project_selection($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality']);
		$project->set_errors($this->update_progress_up_to($id_project, 'import'));
		$project->set_inclusion_rule($this->get_inclusion_rule($id_project));
		$project->set_exclusion_rule($this->get_exclusion_rule($id_project));
		$project->set_inclusion_criteria($this->get_criteria($id_project, "Inclusion"));
		$project->set_exclusion_criteria($this->get_criteria($id_project, "Exclusion"));
		$project->set_papers($this->get_papers_selection($id_project));
		$project->set_databases($this->get_databases($id_project));
		$project->set_questions_extraction($this->get_qes($id_project));

		return $project;
	}

	public function get_project_quality($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection']);
		$project->set_errors($this->update_progress_up_to($id_project, 'selection'));
		$project->set_questions_quality($this->get_qas($id_project));
		$project->set_papers($this->get_papers_qa($id_project));
		$project->set_members($this->get_members($id_project));

		return $project;
	}

	public function get_project_extraction($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality']);
		$project->set_errors($this->update_progress_up_to($id_project, 'quality'));
		$project->set_papers($this->get_papers_ex($id_project));
		$project->set_questions_extraction($this->get_qes($id_project));

		return $project;
	}

	public function get_project_overview($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality', 'extraction', 'description', 'objectives']);
		$project->set_errors($this->update_progress_up_to($id_project, 'extraction'));
		$project->set_members($this->get_members($id_project));

		return $project;
	}

	public function get_project_report($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality', 'extraction']);
		$project->set_errors($this->update_progress_up_to($id_project, 'extraction'));
		$project->set_questions_quality($this->get_qas($id_project));
		$project->set_members($this->get_members($id_project));

		return $project;
	}

	public function get_project_export($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality', 'extraction', 'description', 'objectives']);
		$project->set_errors($this->update_progress_up_to($id_project, 'extraction'));
		$project->set_members($this->get_members($id_project));
		$this->set_full_planning_relations($project, $id_project);

		return $project;
	}

	public function get_project_export_latex($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'import', 'selection', 'quality', 'extraction', 'description', 'objectives']);
		$project->set_errors($this->update_progress_up_to($id_project, 'extraction'));
		$project->set_members($this->get_researchers($id_project));
		$this->set_full_planning_relations($project, $id_project);

		return $project;
	}

	public function get_project_planning($id_project)
	{
		$project = $this->fetch_base_project($id_project, ['planning', 'start_date', 'end_date']);
		$project->set_errors([]);
		$this->set_full_planning_relations($project, $id_project);

		return $project;
	}

	public function get_project_edit($id_project)
	{
		return $this->fetch_base_project($id_project, ['description', 'objectives']);
	}

	public function get_project_members($id_project)
	{
		$project = $this->fetch_base_project($id_project, []);
		$project->set_members($this->get_members($id_project));

		return $project;
	}

	// =========================================================================
	// Private — shared relation loader for planning/export views
	// =========================================================================

	/**
	 * Sets all the planning-related relations on a project object.
	 * Used by get_project_planning, get_project_export, get_project_export_latex.
	 */
	private function set_full_planning_relations($project, $id_project)
	{
		$project->set_domains($this->get_domains($id_project));
		$project->set_languages($this->get_languages($id_project));
		$project->set_study_types($this->get_study_types($id_project));
		$project->set_keywords($this->get_keywords($id_project));
		$project->set_databases($this->get_databases($id_project));
		$project->set_research_questions($this->get_rqs($id_project));
		$project->set_search_strategy($this->get_search_strategy($id_project));
		$project->set_search_strings($this->get_search_strings($id_project));
		$project->set_terms($this->get_terms($id_project));
		$project->set_inclusion_rule($this->get_inclusion_rule($id_project));
		$project->set_exclusion_rule($this->get_exclusion_rule($id_project));
		$project->set_inclusion_criteria($this->get_criteria($id_project, "Inclusion"));
		$project->set_exclusion_criteria($this->get_criteria($id_project, "Exclusion"));
		$project->set_quality_scores($this->get_general_scores($id_project));
		$project->set_score_min($this->get_min_to_app($id_project));
		$project->set_questions_quality($this->get_qas($id_project));
		$project->set_questions_extraction($this->get_qes($id_project));
	}

	// =========================================================================
	// Public — Project CRUD
	// =========================================================================

	public function create_project($title, $description, $objectives, $email)
	{
		$user       = $this->get_id_name_user($email);
		$created_by = $user[0];
		$name       = $user[1];

		$this->db->insert('project', [
			'title'       => $title,
			'description' => $description,
			'created_by'  => $created_by,
			'objectives'  => $objectives,
		]);
		$id_project = $this->db->insert_id();

		$defaults = ['id_project' => $id_project, 'description' => " "];
		$this->db->insert('search_string_generics', $defaults);
		$this->db->insert('search_strategy', $defaults);

		$this->db->insert('inclusion_rule', ['id_project' => $id_project, 'id_rule' => 2]);
		$this->db->insert('exclusion_rule', ['id_project' => $id_project, 'id_rule' => 2]);
		$this->db->insert('members',        ['id_project' => $id_project, 'id_user' => $created_by, 'level' => 1]);

		$project = new Project();
		$project->set_title($title);
		$project->set_created_by($name);
		$project->set_id($id_project);
		$project->set_description($description);
		$project->set_objectives($objectives);
		$project->set_members($name);

		return $id_project;
	}

	/** @deprecated Use create_project() */
	public function created_project($title, $description, $objectives, $email)
	{
		return $this->create_project($title, $description, $objectives, $email);
	}

	public function edit_project($title, $description, $objectives, $id_project)
	{
		$this->db->where('id_project', $id_project);
		$this->db->update('project', [
			'title'       => $title,
			'description' => $description,
			'objectives'  => $objectives,
		]);
	}

	public function delete_project($id_project)
	{
		$this->db->where('id_project', $id_project);
		$this->db->delete('project');
	}

	/** @deprecated Use delete_project() */
	public function deleted_project($id_project)
	{
		$this->delete_project($id_project);
	}

	// =========================================================================
	// Private — Progress updaters
	// =========================================================================

	private function exist_row($table, $id_project, $where = [], $join = [])
	{
		$this->db->select('*');
		$this->db->from($table);

		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		} else {
			$this->db->where('id_project', $id_project);
		}

		return $this->db->get()->num_rows() > 0;
	}

	private function get_project_databases($id_project)
	{
		$this->db->select('name');
		$this->db->from('project_databases');
		$this->db->join('data_base', 'data_base.id_database = project_databases.id_database');
		$this->db->where('id_project', $id_project);

		$names = [];
		foreach ($this->db->get()->result() as $row) {
			$names[] = $row->name;
		}
		return $names;
	}

	private function update_progress_planning($id_project)
	{
		$errors   = [];
		$progress = 11;

		$checks = [
			['domain',                  [],                                 [],                 2.75, "Add Domains"],
			['project_languages',       [],                                 [],                 2.75, "Add Languages"],
			['project_study_types',     [],                                 [],                 2.75, "Add Study Types"],
			['keyword',                 [],                                 [],                 2.75, "Add Keywords"],
			['research_question',       [],                                 [],                 11,   "Add Research Questions"],
			['project_databases',       [],                                 [],                 11,   "Add Databases"],
			['term',                    [],                                 [],                 5.5,  "Add Terms"],
			['search_string',           ['project_databases.id_project' => $id_project],
			                            ['project_databases' => 'project_databases.id_project_database = search_string.id_project_database'],
			                                                                                    5.5,  "Add Search Strings"],
			['search_strategy',         [],                                 [],                 11,   null],
			['inclusion_rule',          [],                                 [],                 2.75, null],
			['exclusion_rule',          [],                                 [],                 2.75, null],
			['criteria',                ['type' => 'Inclusion'],            [],                 2.75, "Add Inclusion Criteria"],
			['criteria',                ['type' => 'Exclusion'],            [],                 2.75, "Add Exclusion Criteria"],
			['min_to_app',              [],                                 [],                 3.6,  "Add Minimum General Score to Approve"],
			['general_score',           [],                                 [],                 3.6,  "Add Quality Scores"],
			['question_quality',        [],                                 [],                 3.8,  "Add Question Quality"],
			['question_extraction',     [],                                 [],                 12,   "Add Question Extraction"],
		];

		foreach ($checks as [$table, $where, $join, $points, $error_msg]) {
			if ($this->exist_row($table, $id_project, $where, $join)) {
				$progress += $points;
			} elseif ($error_msg !== null) {
				$errors[] = $error_msg;
			}
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['planning' => number_format((float)$progress, 2)]);

		return $errors;
	}

	private function update_progress_import($id_project)
	{
		$errors   = [];
		$progress = 0;
		$p_data   = $this->get_project_databases($id_project);

		if (!empty($p_data)) {
			$peso = 100 / count($p_data);
			foreach ($p_data as $database) {
				if ($this->get_num_bib($database, $id_project) > 0) {
					$progress += $peso;
				} else {
					$errors[] = "Add papers at " . $database;
				}
			}
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['import' => number_format((float)$progress, 2)]);

		return $errors;
	}

	private function update_progress_selection($id_project)
	{
		$errors       = [];
		$progress     = 0;
		$count_papers = $this->count_papers_by_status_sel($id_project);

		if ($count_papers[6] > 0 && $count_papers[1] > 0) {
			$unc      = ($count_papers[3] * 100) / $count_papers[6];
			$progress = 100 - $unc;
		}

		if ($progress == 0) {
			$errors[] = "Evaluate at least one paper in the selection step to move to the quality step";
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['selection' => number_format((float)$progress, 2)]);

		return $errors;
	}

	private function update_progress_quality($id_project)
	{
		$errors       = [];
		$progress     = 0;
		$count_papers = $this->count_papers_by_status_qa($id_project);

		if ($count_papers[5] > 0 && $count_papers[1] > 0) {
			$unc      = ($count_papers[3] * 100) / $count_papers[5];
			$progress = 100 - $unc;
		}

		if ($progress == 0) {
			$errors[] = "Evaluate at least one paper in the quality step to move to the extraction step";
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['quality' => number_format((float)$progress, 2)]);

		return $errors;
	}

	private function update_progress_extraction($id_project)
	{
		$errors       = [];
		$progress     = 0;
		$count_papers = $this->count_papers_extraction($id_project);

		if ($count_papers[4] > 0) {
			$unc      = ($count_papers[2] * 100) / $count_papers[4];
			$progress = 100 - $unc;
			$errors[] = "There are still " . number_format((float)$unc, 2) . " of the articles to be evaluated in the extraction.";
		} else {
			$errors[] = "Evaluate at least one paper in the extraction step to move to the reporting step";
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['extraction' => number_format((float)$progress, 2)]);

		return $errors;
	}

	// =========================================================================
	// Private — Data getters (members, domains, papers, etc.)
	// =========================================================================

	/**
	 * Loads members for a project, optionally filtering by allowed level IDs.
	 */
	private function load_members($id_project, array $level_filter = [])
	{
		$this->db->select('name, email, levels.level');
		$this->db->from('members');
		$this->db->join('user',   'user.id_user = members.id_user');
		$this->db->join('levels', 'levels.id_level = members.level');
		$this->db->where('id_project', $id_project);

		if (!empty($level_filter)) {
			$this->db->where_in('members.level', $level_filter);
		}

		$members = [];
		foreach ($this->db->get()->result() as $row) {
			$user = new User();
			$user->set_email($row->email);
			$user->set_level($row->level);
			$user->set_name($row->name);
			$members[] = $user;
		}
		return $members;
	}

	private function get_members($id_project)
	{
		return $this->load_members($id_project);
	}

	private function get_researchers($id_project)
	{
		return $this->load_members($id_project, [self::LEVEL_ADMIN, self::LEVEL_REVIEWER, 4]);
	}

	/** @deprecated Use get_researchers() */
	private function get_researchs($id_project)
	{
		return $this->get_researchers($id_project);
	}

	private function get_domains($id_project)
	{
		$this->db->select('*');
		$this->db->from('domain');
		$this->db->where('id_project', $id_project);

		$domains = [];
		foreach ($this->db->get()->result() as $row) {
			$domains[] = $row->description;
		}
		return $domains;
	}

	private function get_languages($id_project)
	{
		$this->db->select('language.description');
		$this->db->from('project_languages');
		$this->db->join('language', 'language.id_language = project_languages.id_language');
		$this->db->where('id_project', $id_project);

		$languages = [];
		foreach ($this->db->get()->result() as $row) {
			$languages[] = $row->description;
		}
		return $languages;
	}

	private function get_study_types($id_project)
	{
		$this->db->select('study_type.description');
		$this->db->from('project_study_types');
		$this->db->join('study_type', 'study_type.id_study_type = project_study_types.id_study_type');
		$this->db->where('id_project', $id_project);

		$types = [];
		foreach ($this->db->get()->result() as $row) {
			$types[] = $row->description;
		}
		return $types;
	}

	private function get_keywords($id_project)
	{
		$this->db->select('*');
		$this->db->from('keyword');
		$this->db->where('id_project', $id_project);

		$keywords = [];
		foreach ($this->db->get()->result() as $row) {
			$keywords[] = $row->description;
		}
		return $keywords;
	}

	private function get_databases($id_project)
	{
		$this->db->select('data_base.*, project_databases.id_project_database');
		$this->db->from('project_databases');
		$this->db->join('data_base', 'data_base.id_database = project_databases.id_database');
		$this->db->where('id_project', $id_project);

		$databases = [];
		foreach ($this->db->get()->result() as $row) {
			$db = new Database();
			$db->set_name($row->name);
			$db->set_link($row->link);
			$databases[] = $db;
		}
		return $databases;
	}

	private function get_rqs($id_project)
	{
		$this->db->select('*');
		$this->db->from('research_question');
		$this->db->where('id_project', $id_project);

		$rqs = [];
		foreach ($this->db->get()->result() as $row) {
			$rq = new Research_Question();
			$rq->set_id($row->id);
			$rq->set_description($row->description);
			$rqs[] = $rq;
		}
		return $rqs;
	}

	private function get_search_strategy($id_project)
	{
		$this->db->select('*');
		$this->db->from('search_strategy');
		$this->db->where('id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			return $row->description;
		}
		return "";
	}

	private function get_search_strings($id_project)
	{
		$sss = [];

		// Generic search strings
		$this->db->select('*');
		$this->db->from('search_string_generics');
		$this->db->where('id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			$db = new Database();
			$db->set_name("Generic");
			$db->set_link("#");

			$ss = new Search_String();
			$ss->set_description($row->description);
			$ss->set_database($db);
			$sss[] = $ss;
		}

		// Per-database search strings
		$this->db->select('search_string.description, data_base.name, data_base.link');
		$this->db->from('search_string');
		$this->db->join('project_databases', 'project_databases.id_project_database = search_string.id_project_database');
		$this->db->join('data_base',         'data_base.id_database = project_databases.id_database');
		$this->db->where('id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			$db = new Database();
			$db->set_name($row->name);
			$db->set_link($row->link);

			$ss = new Search_String();
			$ss->set_description($row->description);
			$ss->set_database($db);
			$sss[] = $ss;
		}

		return $sss;
	}

	private function get_terms($id_project)
	{
		$this->db->select('*');
		$this->db->from('term');
		$this->db->where('id_project', $id_project);

		$terms = [];
		foreach ($this->db->get()->result() as $row) {
			$term = new Term();
			$term->set_description($row->description);

			$this->db->select('*');
			$this->db->from('synonym');
			$this->db->where('id_term', $row->id_term);
			foreach ($this->db->get()->result() as $synonym) {
				$term->set_synonyms($synonym->description);
			}

			$terms[] = $term;
		}
		return $terms;
	}

	private function get_general_scores($id_project)
	{
		$this->db->select('*');
		$this->db->from('general_score');
		$this->db->where('id_project', $id_project);

		$scores = [];
		foreach ($this->db->get()->result() as $row) {
			$score = new Quality_Score();
			$score->set_description($row->description);
			$score->set_end_interval($row->end);
			$score->set_start_interval($row->start);
			$scores[] = $score;
		}
		return $scores;
	}

	private function get_min_to_app($id_project)
	{
		$this->db->select('description, end, start');
		$this->db->from('min_to_app');
		$this->db->join('general_score', 'min_to_app.id_general_score = general_score.id_general_score');
		$this->db->where('min_to_app.id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			$score = new Quality_Score();
			$score->set_description($row->description);
			$score->set_end_interval($row->end);
			$score->set_start_interval($row->start);
			return $score;
		}
		return null;
	}

	private function get_num_bib($database, $id_project)
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
	private function resolve_bib_ids($id_project)
	{
		$ids_project_database = $this->get_ids_project_database($id_project);
		if (empty($ids_project_database)) {
			return [];
		}
		return $this->get_ids_bibs($ids_project_database);
	}

	private function get_papers_selection($id_project)
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
		$query = $this->db->get();

		$statuses = [];
		foreach ($query->result() as $row) {
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
	 * @param int        $id_project
	 * @param int|array|null $status_qa  Pass null for member-view (uses papers_qa join),
	 *                                   an int or array for a direct status_qa WHERE filter.
	 * @param bool       $member_view   When true, uses session user's member record for per-member status.
	 */
	private function load_papers_qa($id_project, $status_qa_filter = null, $member_view = false)
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
		$this->db->where('status_selection', self::STATUS_ACCEPTED);

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

	public function get_papers_qa($id_project)
	{
		return $this->load_papers_qa($id_project, null, true);
	}

	public function get_papers_qa_latex($id_project)
	{
		return $this->load_papers_qa($id_project, self::STATUS_ACCEPTED, false);
	}

	public function get_papers_qa_visitor($id_project)
	{
		return $this->load_papers_qa($id_project, [self::STATUS_ACCEPTED, self::STATUS_REJECTED], false);
	}

	private function get_papers_ex($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('papers.title, papers.id, papers.id_paper, papers.author, papers.year, data_base.name, papers.status_extraction');
		$this->db->from('papers');
		$this->db->join('data_base', 'papers.data_base = data_base.id_database');
		$this->db->where_in('id_bib', $id_bibs);
		$this->db->where('status_qa', self::STATUS_ACCEPTED);

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
	// Public — Lookups & counts
	// =========================================================================

	public function get_level($email, $id_project)
	{
		$this->db->select('level');
		$this->db->from('user');
		$this->db->join('members', 'members.id_user = user.id_user');
		$this->db->where('user.email', $email);
		$this->db->where('id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			return $row->level;
		}
		return null;
	}

	public function get_users($id)
	{
		$id_users = $this->get_ids_users($id);

		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->where_not_in('id_user', $id_users);

		$users = [];
		foreach ($this->db->get()->result() as $row) {
			$user = new User();
			$user->set_name($row->name);
			$user->set_email($row->email);
			$users[] = $user;
		}
		return $users;
	}

	public function get_levels()
	{
		$this->db->select('*');
		$this->db->from('levels');

		$levels = [];
		foreach ($this->db->get()->result() as $row) {
			$levels[] = $row->level;
		}
		return $levels;
	}

	public function get_all_languages()
	{
		$this->db->select('*');
		$this->db->from('language');

		$languages = [];
		foreach ($this->db->get()->result() as $row) {
			$languages[] = $row->description;
		}
		return $languages;
	}

	public function get_all_study_types()
	{
		$this->db->select('*');
		$this->db->from('study_type');

		$types = [];
		foreach ($this->db->get()->result() as $row) {
			$types[] = $row->description;
		}
		return $types;
	}

	public function get_all_databases()
	{
		$this->db->select('*');
		$this->db->from('data_base');

		$databases = [];
		foreach ($this->db->get()->result() as $row) {
			$databases[] = $row->name;
		}
		return $databases;
	}

	public function get_all_rules()
	{
		$this->db->select('*');
		$this->db->from('rule');

		$rules = [];
		foreach ($this->db->get()->result() as $row) {
			$rules[] = $row->description;
		}
		return $rules;
	}

	public function get_all_types()
	{
		$this->db->select('*');
		$this->db->from('types_question');

		$types = [];
		foreach ($this->db->get()->result() as $row) {
			$types[] = $row->type;
		}
		return $types;
	}

	public function get_num_papers($id_project)
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

	public function get_name_bibs($id_project)
	{
		$data = [];
		foreach ($this->get_databases($id_project) as $database) {
			$id_database         = $this->get_id_database($database->get_name());
			$id_project_database = $this->get_id_project_database($id_database, $id_project);

			$this->db->select('name');
			$this->db->from('bib_upload');
			$this->db->where('id_project_database', $id_project_database);

			$names = [];
			foreach ($this->db->get()->result() as $row) {
				$names[] = $row->name;
			}
			$data[$database->get_name()] = $names;
		}
		return $data;
	}

	public function count_papers_by_status_sel($id_project)
	{
		$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];
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

	public function count_papers_by_status_qa($id_project)
	{
		$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
		$total = 0;

		$id_bibs = $this->resolve_bib_ids($id_project);
		if (!empty($id_bibs)) {
			$this->db->select('status_qa, COUNT(*) as count');
			$this->db->from('papers');
			$this->db->group_by('status_qa');
			$this->db->where_in('id_bib', $id_bibs);
			$this->db->where('status_selection', self::STATUS_ACCEPTED);

			foreach ($this->db->get()->result() as $row) {
				$cont[$row->status_qa] = $row->count;
				$total += $row->count;
			}
		}
		$cont[5] = $total;
		return $cont;
	}

	public function get_logs_project($id_project)
	{
		$this->db->select('name, activity, time');
		$this->db->from('activity_log');
		$this->db->join('user', 'user.id_user = activity_log.id_user');
		$this->db->where('activity_log.id_project', $id_project);
		$this->db->order_by('activity_log.time DESC');

		$data = [];
		foreach ($this->db->get()->result() as $row) {
			$data[] = ['name' => $row->name, 'activity' => $row->activity, 'time' => $row->time];
		}
		return $data;
	}

	public function get_status()
	{
		$this->db->select('*');
		$this->db->from('status_selection');

		$levels = [];
		foreach ($this->db->get()->result() as $row) {
			$levels[] = [$row->id_status, $row->description];
		}
		return $levels;
	}

	public function get_status_qa()
	{
		$this->db->select('*');
		$this->db->from('status_qa');

		$levels = [];
		foreach ($this->db->get()->result() as $row) {
			$levels[] = [$row->id_status, $row->status];
		}
		return $levels;
	}

	// =========================================================================
	// Public — Members management
	// =========================================================================

	public function add_member($email, $level, $id_project)
	{
		$id_level = $this->get_level_id_by_name($level);
		$id_user  = $this->get_id_name_user($email);

		$this->db->insert('members', [
			'id_user'    => $id_user[0],
			'id_project' => $id_project,
			'level'      => $id_level,
		]);
		$id_member = $this->db->insert_id();

		if ($id_level == self::LEVEL_ADMIN || $id_level == self::LEVEL_REVIEWER) {
			$this->provision_reviewer_papers($id_member, $id_project);
		}

		return $id_user[1];
	}

	public function delete_member($email, $id_project)
	{
		$this->validate_adm($email, $id_project);

		$user      = $this->get_id_name_user($email);
		$id_member = $this->get_id_member($user[0], $id_project);

		$this->db->where('id_project', $id_project);
		$this->db->where('id_members', $id_member);
		$this->db->delete('members');

		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return;
		}

		$this->db->select('id_paper');
		$this->db->from('papers');
		$this->db->where_in('id_bib', $id_bibs);
		$paper_ids = array_column($this->db->get()->result(), 'id_paper');

		foreach ($paper_ids as $id_paper) {
			$this->db->select('id_status');
			$this->db->from('papers_selection');
			$this->db->where('id_paper', $id_paper);
			$statuses = array_column($this->db->get()->result(), 'id_status');

			$all_same = count(array_unique($statuses)) === 1;

			if ($all_same) {
				$this->db->where('id_paper', $id_paper);
				$this->db->update('papers', ['status_selection' => $statuses[0]]);
			} else {
				$this->db->where('id_paper', $id_paper);
				$this->db->update('papers', [
					'status_selection'       => self::STATUS_UNCLASSIFIED,
					'check_status_selection' => false,
				]);
			}
		}
	}

	public function edit_level($email, $level, $id_project)
	{
		$this->validate_adm($email, $id_project);

		$id_level  = $this->get_level_id_by_name($level);
		$user      = $this->get_id_name_user($email);
		$id_member = $this->get_id_member($user[0], $id_project);
		$old_level = $this->get_current_member_level($id_member, $id_project);

		if ($id_level === $old_level) {
			return true;
		}

		$this->db->where('id_members', $id_member);
		$this->db->update('members', ['level' => $id_level]);

		$is_reviewer     = $id_level  == self::LEVEL_ADMIN || $id_level  == self::LEVEL_REVIEWER;
		$was_reviewer    = $old_level == self::LEVEL_ADMIN || $old_level == self::LEVEL_REVIEWER;

		if ($is_reviewer && !$was_reviewer) {
			$this->provision_reviewer_papers($id_member, $id_project);
		} elseif (!$is_reviewer) {
			$this->db->where('id_member', $id_member)->delete('papers_selection');
			$this->db->where('id_member', $id_member)->delete('papers_qa');
		}
	}

	// =========================================================================
	// Private — Member helpers
	// =========================================================================

	private function get_level_id_by_name($level)
	{
		$this->db->select('id_level');
		$this->db->from('levels');
		$this->db->where('level', $level);
		foreach ($this->db->get()->result() as $row) {
			return $row->id_level;
		}
		return null;
	}

	private function get_current_member_level($id_member, $id_project)
	{
		$this->db->select('id_level');
		$this->db->from('levels');
		$this->db->join('members', 'members.level = levels.id_level');
		$this->db->where('id_members', $id_member);
		$this->db->where('id_project', $id_project);
		foreach ($this->db->get()->result() as $row) {
			return $row->id_level;
		}
		return null;
	}

	/**
	 * Inserts papers_selection and papers_qa rows for a newly-added reviewer member,
	 * and resets papers statuses to UNCLASSIFIED.
	 */
	private function provision_reviewer_papers($id_member, $id_project)
	{
		$id_bibs   = $this->resolve_bib_ids($id_project);
		$id_papers = !empty($id_bibs) ? $this->get_ids_papers($id_bibs) : [];

		if (empty($id_papers)) {
			return;
		}

		$gen_score        = $this->gen_score_min($id_project);
		$status_selection = [];
		$status_qa        = [];

		foreach ($id_papers as $paper) {
			$status_selection[] = [
				'id_paper'  => $paper,
				'id_member' => $id_member,
				'id_status' => self::STATUS_UNCLASSIFIED,
				'note'      => "",
			];
			$status_qa[] = [
				'id_paper'     => $paper,
				'id_member'    => $id_member,
				'id_status'    => self::STATUS_UNCLASSIFIED,
				'note'         => "",
				'score'        => 0,
				'id_gen_score' => $gen_score,
			];
		}

		$this->db->insert_batch('papers_selection', $status_selection);
		$this->db->insert_batch('papers_qa', $status_qa);

		$this->db->where_in('id_paper', $id_papers);
		$this->db->update('papers', [
			'status_selection'       => self::STATUS_UNCLASSIFIED,
			'check_status_selection' => false,
			'status_qa'              => self::STATUS_UNCLASSIFIED,
			'check_qa'               => false,
			'id_gen_score'           => $gen_score,
			'score'                  => 0,
		]);
	}

	private function validate_adm($email, $id_project)
	{
		$members = $this->get_members($id_project);

		if (count($members) == 1) {
			throw new Exception('The project must contain at least one member and this is the administrator.');
		}

		foreach ($members as $mem) {
			if ($mem->get_level() == "Administrator" && $mem->get_email() != $email) {
				return true;
			}
		}

		throw new Exception('The project must contain at least one member and this is the administrator.');
	}

	// =========================================================================
	// Public — Paper counts & reviewer stats
	// =========================================================================

	/**
	 * Counts paper statuses per reviewer member. Returns [email => [status_id => count, ...]] for
	 * selection or QA, depending on $table and $total_key.
	 */
	private function count_papers_reviewer_generic($id_project, $table, $id_papers_getter, $total_key)
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
			if ($level != self::LEVEL_ADMIN && $level != self::LEVEL_REVIEWER) {
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

			$cont[$total_key]          = $total;
			$data[$mem->get_email()]   = $cont;
		}
		return $data;
	}

	public function count_papers_reviewer($id_project)
	{
		return $this->count_papers_reviewer_generic($id_project, 'papers_selection', 'get_ids_papers', 6);
	}

	public function count_papers_reviewer_qa($id_project)
	{
		return $this->count_papers_reviewer_generic($id_project, 'papers_qa', 'get_ids_papers_qa', 5);
	}

	public function count_papers_sel_by_user($id_project)
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

	public function count_papers_qa_by_user($id_project)
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

	public function count_papers_extraction($id_project)
	{
		$cont  = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
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
			$cont[4] = $total;
		}
		return $cont;
	}

	// =========================================================================
	// Public — Evaluation & selection
	// =========================================================================

	private function get_criteria_evaluation($id_paper, $id_cri, $id_member)
	{
		$this->db->select('id_evaluation_criteria');
		$this->db->from('evaluation_criteria');
		$this->db->where('evaluation_criteria.id_paper',    $id_paper);
		$this->db->where('evaluation_criteria.id_criteria', $id_cri);
		$this->db->where('evaluation_criteria.id_member',   $id_member);

		return $this->db->get()->num_rows() > 0 ? "True" : "False";
	}

	public function get_evaluation_selection($id_project)
	{
		$user      = $this->get_id_name_user($this->session->email);
		$id_member = $this->get_id_member($user[0], $id_project);

		$id_bibs   = $this->resolve_bib_ids($id_project);
		$ids_paper = !empty($id_bibs) ? $this->get_ID_papers_to_selection($id_bibs) : [];

		$criteria = !empty($id_bibs)
			? array_merge(
				$this->get_criteria($id_project, "Inclusion"),
				$this->get_criteria($id_project, "Exclusion")
			)
			: null;

		$papers = [];
		foreach ($ids_paper as $id_paper) {
			$id  = $this->get_id_paper($id_paper, $id_bibs);
			$cri = [];
			foreach ($criteria as $c) {
				$cri[$c->get_id()] = $this->get_criteria_evaluation($id, $this->get_ids_criteria($id_project, $c->get_id()), $id_member);
			}
			$papers[$id_paper] = $cri;
		}
		return $papers;
	}

	// =========================================================================
	// Public — Reporting / charts
	// =========================================================================

	public function get_papers_database($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('name, COUNT(*) as count');
		$this->db->from('papers');
		$this->db->join('data_base', 'data_base.id_database = papers.data_base');
		$this->db->group_by('data_base');
		$this->db->where_in('id_bib', $id_bibs);

		$data = [];
		foreach ($this->db->get()->result() as $row) {
			$data[] = ['name' => $row->name, 'y' => (int)$row->count];
		}
		return $data;
	}

	public function get_papers_status_selection($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('status_selection.description, COUNT(*) as count');
		$this->db->from('papers');
		$this->db->join('status_selection', 'papers.status_selection = status_selection.id_status');
		$this->db->group_by('papers.status_selection');
		$this->db->where_in('papers.id_bib', $id_bibs);

		$color_map = [
			'Accepted'     => '#90ed7d',
			'Rejected'     => '#f45b5b',
			'Unclassified' => '#434348',
			'Duplicate'    => '#e4d354',
			'Removed'      => '#7cb5ec',
		];

		$data = [];
		foreach ($this->db->get()->result() as $row) {
			$color = $color_map[$row->description] ?? null;
			$entry = ['name' => $row->description, 'y' => (int)$row->count];
			if ($color) {
				$entry['color'] = $color;
			}
			$data[] = $entry;
		}
		return $data;
	}

	public function get_papers_status_quality($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('status_qa.status, COUNT(*) as count');
		$this->db->from('papers');
		$this->db->join('status_qa', 'papers.status_qa = status_qa.id_status');
		$this->db->group_by('papers.status_qa');
		$this->db->where_in('papers.id_bib', $id_bibs);
		$this->db->where('status_selection', self::STATUS_ACCEPTED);

		$color_map = [
			'Accepted'     => '#90ed7d',
			'Rejected'     => '#f45b5b',
			'Unclassified' => '#434348',
			'Removed'      => '#7cb5ec',
		];

		$data = [];
		foreach ($this->db->get()->result() as $row) {
			$color = $color_map[$row->status] ?? null;
			$entry = ['name' => $row->status, 'y' => (int)$row->count];
			if ($color) {
				$entry['color'] = $color;
			}
			$data[] = $entry;
		}
		return $data;
	}

	public function get_papers_step($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		$data    = [];

		if (!empty($id_bibs)) {
			$step_queries = [
				['label' => 'Imported Studies', 'where' => null,                              'where_not_in' => null],
				['label' => 'Not Duplicate',    'where' => null,                              'where_not_in' => ['status_selection', [self::STATUS_DUPLICATE]]],
				['label' => 'Status Selection', 'where' => ['status_selection' => self::STATUS_ACCEPTED], 'where_not_in' => null],
				['label' => 'Status Quality',   'where' => ['status_qa'        => self::STATUS_ACCEPTED], 'where_not_in' => null],
				['label' => 'Status Extraction','where' => ['status_extraction' => self::STATUS_ACCEPTED],'where_not_in' => null],
			];

			foreach ($step_queries as $step) {
				$this->db->select('COUNT(*) as count');
				$this->db->from('papers');
				$this->db->where_in('id_bib', $id_bibs);

				if ($step['where']) {
					foreach ($step['where'] as $col => $val) {
						$this->db->where($col, $val);
					}
				}
				if ($step['where_not_in']) {
					$this->db->where_not_in($step['where_not_in'][0], $step['where_not_in'][1]);
				}

				foreach ($this->db->get()->result() as $row) {
					$data[] = [$step['label'], (int)$row->count];
				}
			}
		}

		return ['name' => 'Studies', 'data' => $data];
	}

	public function get_act_project($id_project)
	{
		$mems  = $this->get_members_name_id($id_project);
		$days  = [];
		$all_data = [];

		$this->db->select('CAST(time as date) as day, COUNT(*) as count');
		$this->db->from('activity_log');
		$this->db->group_by('day');
		$this->db->where('id_project', $id_project);
		$query = $this->db->get();

		$project_data = [];
		foreach ($query->result() as $row) {
			$project_data[] = (int)$row->count;
			$days[]         = $row->day;
		}

		$series   = [];
		$series[] = ['name' => 'Project', 'data' => $project_data];

		foreach ($mems as $mem) {
			$mem_data = [];
			foreach ($days as $day) {
				$this->db->select('COUNT(*) as count');
				$this->db->from('activity_log');
				$this->db->where('id_project', $id_project);
				$this->db->where('id_user', $mem[0]);
				$this->db->where('CAST(time as date) =', $day);
				$query = $this->db->get();

				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$mem_data[] = (int)$row->count;
					}
				} else {
					$mem_data[] = null;
				}
			}
			$series[] = ['name' => $mem[1], 'data' => $mem_data];
		}

		return ['categories' => $days, 'series' => $series];
	}

	public function get_papers_score_quality($id_project)
	{
		$id_bibs = $this->resolve_bib_ids($id_project);
		if (empty($id_bibs)) {
			return [];
		}

		$this->db->select('general_score.description as desc, COUNT(*) as count');
		$this->db->from('papers');
		$this->db->join('general_score', 'general_score.id_general_score = papers.id_gen_score');
		$this->db->group_by('papers.id_gen_score');
		$this->db->where_in('papers.id_bib', $id_bibs);
		$this->db->where('status_selection', self::STATUS_ACCEPTED);

		$data = [];
		foreach ($this->db->get()->result() as $row) {
			$data[] = ['name' => $row->desc, 'y' => (int)$row->count];
		}
		return $data;
	}

	private function get_id_qe($id, $id_project)
	{
		$this->db->select('id_de');
		$this->db->from('question_extraction');
		$this->db->where('id', $id);
		$this->db->where('id_project', $id_project);

		foreach ($this->db->get()->result() as $row) {
			return $row->id_de;
		}
		return null;
	}

	public function get_data_qes_select($id_project)
	{
		$data = [];
		foreach ($this->get_qes($id_project) as $qe) {
			if ($qe->get_type() !== "Pick One List") {
				continue;
			}

			$id_qe = $this->get_id_qe($qe->get_id(), $id_project);

			$this->db->select('options_extraction.description, COUNT(*) as count');
			$this->db->from('evaluation_ex_op');
			$this->db->join('options_extraction', 'options_extraction.id_option = evaluation_ex_op.id_option');
			$this->db->group_by('evaluation_ex_op.id_option');
			$this->db->where('evaluation_ex_op.id_qe', $id_qe);

			$data2 = [];
			foreach ($this->db->get()->result() as $row) {
				$data2[] = ['name' => $row->description, 'y' => (int)$row->count];
			}
			$data[] = ['id' => $qe->get_id(), 'type' => $qe->get_type(), 'data' => $data2];
		}
		return $data;
	}

	public function get_data_qes_multiple($id_project)
	{
		$id_bibs   = $this->resolve_bib_ids($id_project);
		$id_papers = !empty($id_bibs) ? $this->get_ids_papers_chars($id_bibs) : [];
		$qes       = !empty($id_papers) ? $this->get_qes($id_project) : [];

		$data = [];
		foreach ($qes as $qe) {
			if ($qe->get_type() !== "Multiple Choice List") {
				continue;
			}

			$id_qe = $this->get_id_qe($qe->get_id(), $id_project);
			$data2 = [];

			foreach ($qe->get_options() as $op) {
				$id_option              = $this->get_id_option($op, $id_qe);
				$data2[$id_option]      = ['sets' => [$op], 'value' => 0];
			}

			foreach ($id_papers as $id_paper) {
				$sets = [];
				$id   = "";

				$this->db->select('evaluation_ex_op.id_option, options_extraction.description');
				$this->db->from('evaluation_ex_op');
				$this->db->join('options_extraction', 'options_extraction.id_option = evaluation_ex_op.id_option');
				$this->db->where('id_paper', $id_paper);
				$this->db->where('id_qe', $id_qe);
				$this->db->order_by('evaluation_ex_op.id_option', 'asc');

				$cont = 0;
				foreach ($this->db->get()->result() as $row) {
					$sets[]                        = $row->description;
					$id                           .= $row->id_option;
					$data2[$row->id_option]['value'] += 1;
					$cont++;
				}

				$data2[$id]['sets'] = $sets;
				if ($cont > 1) {
					$data2[$id]['value'] = ($data2[$id]['value'] ?? 0) + 1;
				}
			}

			$data[] = ['id' => $qe->get_id(), 'type' => $qe->get_type(), 'data' => array_values($data2)];
		}
		return $data;
	}

	public function export_bib($id_project, $steps)
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
				$this->db->where('status_extraction', self::STATUS_ACCEPTED);
				break;
			case 'Quality':
				$this->db->where('status_qa', self::STATUS_ACCEPTED);
				break;
			case 'Selection':
				$this->db->where('status_selection', self::STATUS_ACCEPTED);
				break;
		}

		$papers = [];
		foreach ($this->db->get()->result() as $row) {
			$p = new Paper();
			$p->set_id($row->id);
			$p->set_title($row->title);
			$p->set_author($row->author);
			$p->set_year($row->year);
			$p->set_address($row->address); // Fixed: was incorrectly set to $row->year
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
