<?php

final class Algolia_Projets_Index extends Algolia_Index
{
	/**
	 * @var string
	 */
	protected $contains_only = 'bp_groups';

	/**
	 * @return string The name displayed in the admin UI.
	 */
	public function get_admin_name()
	{
		return __( 'Projets', 'telabotanica' );
	}

	/**
	 * @param $item
	 *
	 * @return bool
	 */
	protected function should_index( $item )
	{
		// get_items() already filters hidden groups
		$should_index = true;

		// compatibility with bp-moderate-group-creation plugin
		$published_state = groups_get_groupmeta($item->id, 'published');
		$should_index = ($published_state !== "0");

		return (bool) apply_filters( 'algolia_should_index_group', $should_index, $item );
	}

	/**
	 * @param $item
	 *
	 * @return array
	 */
	protected function get_records( $item )
	{
		$record = array();
    $this->get_logger()->log_operation( sprintf( 'get_records %s', '' ), $item );
		$record['objectID'] = $item->id;
		$record['name'] = $item->name;
		$record['description'] = $item->description;
    $record['permalink'] = bp_get_group_permalink( $item );

		$record = (array) apply_filters( 'algolia_group_record', $record, $item );

		return array( $record );
	}

	/**
	 * @return int
	 */
	protected function get_re_index_items_count()
	{
		$results = $this->query_non_hidden_groups();

		return (int) $results['total'];
	}

	/**
	 * @return array
	 */
	protected function get_settings()
	{
		$settings = array(
			'attributesToIndex' => array(
				'name',
				'description',
			),
			// 'customRanking' => array(
			// 	'desc(posts_count)',
			// ),
		);

		return (array) apply_filters( 'algolia_groups_index_settings', $settings );
	}

	/**
	 * @return array
	 */
	protected function get_synonyms()
	{
		return (array) apply_filters( 'algolia_groups_index_synonyms', array() );
	}

	/**
	 * @return string
	 */
	public function get_id()
	{
		return 'groups';
	}


	/**
	 * @param int $page
	 * @param int $batch_size
	 *
	 * @return array
	 */
	protected function get_items( $page, $batch_size )
	{
		$results = $this->query_non_hidden_groups($page, $batch_size);

		// We use prior to 4.5 syntax for BC purposes, no `paged` arg.
		return $results['groups'];
	}

	/**
	 * Returns all BP groups having a status different from "hidden"
	 * 
	 * @param int $page page
	 * @param int $batch_size
	 * @return array
	 */
	protected function query_non_hidden_groups($page=null, $batch_size=null)
	{
		$args = array(
			'order'			=> 'ASC',
			'orderby'		=> 'name',
			'page'			=> $page,
			'per_page'		=> $batch_size,
			'type'			=> 'alphabetical',
			'show_hidden'	=> false
		);
		$results = BP_Groups_Group::get($args);

		return $results;
	}

	/**
	 * A performing function that return true if the item can potentially
	 * be subject for indexation or not. This will be used to determine if a task can be queued
	 * for this index. As this function will be called synchronously during other operations,
	 * it has to be as lightweight as possible. No db calls or huge loops.
	 *
	 * @param mixed $task_data
	 *
	 * @return bool
	 */
	public function supports($task_data)
	{
		return true;
	}

	/**
	 * @param Algolia_Task $task
	 *
	 * @return mixed
	 */
	protected function extract_item( Algolia_Task $task )
	{
		$data = $task->get_data();
		if ( ! isset( $data['group_id'] ) ) {
			return;
		}

		$group = groups_get_group( $data['group_id'] );

		return  ! $group ? null : $group ;
	}

	public function get_default_autocomplete_config() {
		$config = array(
			'position'        => 30,
			'max_suggestions' => 3,
			'tmpl_suggestion' => 'autocomplete-group-suggestion',
		);

		return array_merge( parent::get_default_autocomplete_config(), $config );
	}

	/**
	 * @param Algolia_Task $task
	 */
	public function delete_item( Algolia_Task $task ) {
		$data = $task->get_data();
		if ( ! isset( $data['group_id'] ) || ! is_int( $data['group_id'] ) ) {
			return;
		}

		$index = $this->get_index();
		$index->deleteObject( $data['group_id'] );
		$this->get_logger()->log_operation( sprintf( '[1] Deleted 1 record from index %s', $index->indexName ) );
	}
}
