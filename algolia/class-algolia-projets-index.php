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
		// TODO: compose record for group
		$record = array();
		$record['objectID'] = $item->ID;
		$record['user_id'] = $item->ID;
		$record['display_name'] = $item->display_name;
		$record['posts_url'] = get_author_posts_url( $item->ID, $item->user_nicename );
		$record['description'] = get_the_author_meta( 'description', $item->ID );

		if ( function_exists( 'wpcom_vip_count_user_posts' ) ) {
			$record['posts_count'] = (int) wpcom_vip_count_user_posts( $item->ID );
		} else {
			$record['posts_count'] = (int) count_user_posts( $item->ID );
		}

		$avatar_size = 32;
		if ( function_exists( 'get_avatar_url' ) ) {
			$record['avatar_url'] = get_avatar_url( $item->ID, array( 'size' => $avatar_size ) );
		} else {
			$email_hash = md5( strtolower( trim( $item->user_email ) ) );
			$record['avatar_url'] = 'https://www.gravatar.com/avatar/' . $email_hash . '?s=' . $avatar_size;
		}

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
		// TODO: define settings
		$settings = array(
			'attributesToIndex' => array(
				'unordered(display_name)',
			),
			'customRanking' => array(
				'desc(posts_count)',
			),
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
