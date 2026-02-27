<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'models/Pattern_Model.php';
require_once APPPATH . 'models/Project_Model_Relations.php';
require_once APPPATH . 'models/Project_Model_Members.php';
require_once APPPATH . 'models/Project_Model_Papers.php';
require_once APPPATH . 'models/Project_Model_Reports.php';

class Project_Model extends Pattern_Model
{
	use Project_Model_Relations;
	use Project_Model_Members;
	use Project_Model_Papers;
	use Project_Model_Reports;

	// =========================================================================
	// Constants — Paper / member status codes
	// =========================================================================

	public const STATUS_ACCEPTED     = 1;
	public const STATUS_REJECTED     = 2;
	public const STATUS_UNCLASSIFIED = 3;
	public const STATUS_DUPLICATE    = 4;
	public const STATUS_REMOVED      = 5;

	public const LEVEL_ADMIN    = 1;
	public const LEVEL_REVIEWER = 3;

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

	private function exist_row($table, $id_project, array $where = [], array $join = [])
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

		return array_column($this->db->get()->result(), 'name');
	}

	private function update_progress_planning($id_project)
	{
		$errors   = [];
		$progress = 11;

		$checks = [
			['domain',              [],                                                                                               [],                                                                   2.75, "Add Domains"],
			['project_languages',   [],                                                                                               [],                                                                   2.75, "Add Languages"],
			['project_study_types', [],                                                                                               [],                                                                   2.75, "Add Study Types"],
			['keyword',             [],                                                                                               [],                                                                   2.75, "Add Keywords"],
			['research_question',   [],                                                                                               [],                                                                   11,   "Add Research Questions"],
			['project_databases',   [],                                                                                               [],                                                                   11,   "Add Databases"],
			['term',                [],                                                                                               [],                                                                   5.5,  "Add Terms"],
			['search_string',       ['project_databases.id_project' => $id_project],                                                 ['project_databases' => 'project_databases.id_project_database = search_string.id_project_database'], 5.5, "Add Search Strings"],
			['search_strategy',     [],                                                                                               [],                                                                   11,   null],
			['inclusion_rule',      [],                                                                                               [],                                                                   2.75, null],
			['exclusion_rule',      [],                                                                                               [],                                                                   2.75, null],
			['criteria',            ['type' => 'Inclusion'],                                                                          [],                                                                   2.75, "Add Inclusion Criteria"],
			['criteria',            ['type' => 'Exclusion'],                                                                          [],                                                                   2.75, "Add Exclusion Criteria"],
			['min_to_app',          [],                                                                                               [],                                                                   3.6,  "Add Minimum General Score to Approve"],
			['general_score',       [],                                                                                               [],                                                                   3.6,  "Add Quality Scores"],
			['question_quality',    [],                                                                                               [],                                                                   3.8,  "Add Question Quality"],
			['question_extraction', [],                                                                                               [],                                                                   12,   "Add Question Extraction"],
		];

		foreach ($checks as [$table, $where, $join, $points, $error_msg]) {
			if ($this->exist_row($table, $id_project, $where, $join)) {
				$progress += $points;
			} elseif ($error_msg !== null) {
				$errors[] = $error_msg;
			}
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['planning' => number_format((float) $progress, 2)]);

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
		$this->db->update('project', ['import' => number_format((float) $progress, 2)]);

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
			$errors[] = "Approve at least one paper in the selection step to move to the quality step";
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['selection' => number_format((float) $progress, 2)]);

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
		$this->db->update('project', ['quality' => number_format((float) $progress, 2)]);

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
			$errors[] = "There are still " . number_format((float) $unc, 2) . " of the articles to be evaluated in the extraction.";
		} else {
			$errors[] = "Evaluate at least one paper in the extraction step to move to the reporting step";
		}

		$this->db->where('id_project', $id_project);
		$this->db->update('project', ['extraction' => number_format((float) $progress, 2)]);

		return $errors;
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

		$row = $this->db->get()->row();
		return $row ? (int) $row->level : null;
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

		return array_column($this->db->get()->result(), 'level');
	}

	public function get_all_languages()
	{
		$this->db->select('*');
		$this->db->from('language');

		return array_column($this->db->get()->result(), 'description');
	}

	public function get_all_study_types()
	{
		$this->db->select('*');
		$this->db->from('study_type');

		return array_column($this->db->get()->result(), 'description');
	}

	public function get_all_databases()
	{
		$this->db->select('*');
		$this->db->from('data_base');

		return array_column($this->db->get()->result(), 'name');
	}

	public function get_all_rules()
	{
		$this->db->select('*');
		$this->db->from('rule');

		return array_column($this->db->get()->result(), 'description');
	}

	public function get_all_types()
	{
		$this->db->select('*');
		$this->db->from('types_question');

		return array_column($this->db->get()->result(), 'type');
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

	/**
	 * Get total number of projects
	 * @return int
	 */
	public function get_total_projects()
	{
		$this->db->from('project');
		return $this->db->count_all_results();
	}
}
