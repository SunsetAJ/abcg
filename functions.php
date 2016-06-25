<?php
  /*
  Plugin Name: Aj's Bootstrap Content Grid
  Plugin URI: http://www.abcg.com/
  Version: 0.0.1
  Author: Adriaan J.v.R
  Description: Creates a table in the content area for sites that use Bootstrap
  */
?>

<?php

  $numOfGrids = 0;

  function abcg_register_meta_boxes() {
    add_meta_box( 'meta-box-id', __( 'Bootstrap Content Grid' ), 'abcg_my_display_callback', 'post', 'advanced', 'high' );
  }
  add_action( 'add_meta_boxes', 'abcg_register_meta_boxes' );

  /**
    * @param WP_Post $post Current post object.
  */
  function abcg_my_display_callback( $post ) {
    wp_nonce_field(basename( __FILE__ ), 'acbg_nonce');
    $acbg_stored_meta = get_post_meta( $post->ID );
    ?>
      <h3 style="margin-bottom: 0px;">Add a new Bootstrap Grid:</h3>
      <small style="margin-bottom: 15px; display: block;">* Bootstrap css & js is required for this to work *</small>
      <div class="form-elements">

        <div style="margin-bottom: 20px;" class="test-field">
          <label for="test_id">Test Field ID</label>
          <input type="text" name="test_id" id="test_id"
  				value="<?php if ( ! empty ( $acbg_stored_meta['test_id'] ) ) {
  					echo esc_attr( $acbg_stored_meta['test_id'][0] );
  				} ?>"/>
        </div>

        <div style="margin-bottom: 20px;" class="container-type">
          <h4>Select Container Type</h4>
          <input type="radio" name="container-type" value="container" checked>Normal Container</br>
          <input type="radio" name="container-type" value="fluid-container">Fluid Container</br>
        </div>

        <div style="margin-bottom: 20px;" class="num-of-rows">
          <h4>Select Number of Rows:</h4>
          <select name="numOfRows">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <small>* Once you have selected a NEW number press the update button *</small>
        </div>
      </div>
    <?php
  }

  /**
  * @param int $post_id Post ID
  */
  function dwwp_meta_save( $post_id ) {
  	// Checks save status
      $is_autosave = wp_is_post_autosave( $post_id );
      $is_revision = wp_is_post_revision( $post_id );
      $is_valid_nonce = ( isset( $_POST[ 'acbg_nonce' ] ) && wp_verify_nonce( $_POST[ 'acbg_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
      // Exits script depending on save status
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
          return;
      }
      if ( isset( $_POST[ 'test_id' ] ) ) {
      	update_post_meta( $post_id, 'test_id', sanitize_text_field( $_POST[ 'test_id' ] ) );
      }
  }
  add_action( 'save_post', 'dwwp_meta_save' );

?>
