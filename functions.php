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

        <div style="margin-bottom: 20px;" class="container-type">
          <label for="containerType"><?php _e('Container Type *Default is normal*', 'treehouse_wp') ?></label>
          <select name="containerType" id="containerType">
            <option value="Normal" <?php if (! empty($acbg_stored_meta['containerType'])) selected($acbg_stored_meta['containerType'][0], 'Normal'); ?>><?php _e('Normal', 'treehouse_wp') ?></option>';
            <option value="Fluid" <?php if (! empty($acbg_stored_meta['containerType'])) selected($acbg_stored_meta['containerType'][0], 'Fluid'); ?>><?php _e('Fluid', 'treehouse_wp') ?></option>';
          </select>
        </div>

        <div style="margin-bottom: 20px;" class="num-of-rows">
          <label for="numOfRows"><?php _e('Number of Rows', 'treehouse_wp') ?></label>
          <select name="numOfRows" id="numOfRows">
            <?php
              $rowCount = 6;
              for ($i = 0; $i <= $rowCount; $i++){
                ?> <option value="<?php echo $i ?>" <?php if ( ! empty ( $acbg_stored_meta['numOfRows'] ) ) selected( $acbg_stored_meta['numOfRows'][0], $i ); ?>><?php _e( $i, 'treehouse_wp' )?></option>'; <?php
              }
            ?>
          </select>
          <small><br>* Once you have selected a NEW number press the update button *</small>
        </div>

        <?php
          $num = get_post_meta($post->ID, 'numOfRows', true);

          if ($num >= 1){
            ?>
              <div style="margin-bottom: 20px;" class="columns">
                <h3 style="margin-bottom: 0px;">Enter the Columns</h3>
            <?php
            for ($x = 1; $x <= $num; $x++){
              ?>
                <div class="<?php echo 'row-' . $x . '-columns' ?>">
                  <label for="<?php echo 'row-' . $x . '-columns' ?>"><?php _e('Row ' . $x . ' Columns', 'treehouse_wp') ?></label>
                  <select name="<?php echo 'row-' . $x . '-columns' ?>" id="<?php echo 'row-' . $x . '-columns' ?>">
                    <option value="1" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '1' ); ?>><?php _e( '1', 'treehouse_wp' )?></option>';
                    <option value="2" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '2' ); ?>><?php _e( '2', 'treehouse_wp' )?></option>';
                    <option value="3" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '3' ); ?>><?php _e( '3', 'treehouse_wp' )?></option>';
                    <option value="4" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '4' ); ?>><?php _e( '4', 'treehouse_wp' )?></option>';
                    <option value="5" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '5' ); ?>><?php _e( '5', 'treehouse_wp' )?></option>';
                    <option value="6" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '6' ); ?>><?php _e( '6', 'treehouse_wp' )?></option>';
                    <option value="7" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '7' ); ?>><?php _e( '7', 'treehouse_wp' )?></option>';
                    <option value="8" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '8' ); ?>><?php _e( '8', 'treehouse_wp' )?></option>';
                    <option value="9" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '9' ); ?>><?php _e( '9', 'treehouse_wp' )?></option>';
                    <option value="10" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '10' ); ?>><?php _e( '10', 'treehouse_wp' )?></option>';
                    <option value="11" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '11' ); ?>><?php _e( '11', 'treehouse_wp' )?></option>';
                    <option value="12" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], '12' ); ?>><?php _e( '12', 'treehouse_wp' )?></option>';
                  </select>
                </div>
              <?php
            }
            ?>
              </div>
            <?php
          }
        ?>

      </div>
    <?php
    $content = '<table class="tg">
                  <tr>
                    <th class="tg-yw4l">1</th>
                    <th class="tg-yw4l">1</th>
                  </tr>
                  <tr>
                    <td class="tg-yw4l">2</td>
                    <td class="tg-yw4l">2</td>
                    <td class="tg-yw4l">2</td>
                    <td class="tg-yw4l">2</td>
                  </tr>
                  <tr>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                  </tr>
                  <tr>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                    <td class="tg-yw4l">3</td>
                  </tr>
                </table>';

    wp_editor($content, 'table-area');
  }

  /**
  * @param int $post_id Post ID
  */
  function dwwp_meta_save( $post_id ) {
    $num = 6;
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'acbg_nonce' ] ) && wp_verify_nonce( $_POST[ 'acbg_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    //Saves each of the input fields
    if (isset($_POST['containerType'])){
        update_post_meta($post_id, 'containerType', sanitize_text_field($_POST['containerType']));
    }
    if ( isset( $_POST['numOfRows'])){
      update_post_meta($post_id, 'numOfRows', sanitize_text_field($_POST['numOfRows']));
    }
    //This will be interesting
    if ($num >= 1){
      for ($y = 1; $y <= $num; $y++){
        if ( isset( $_POST['row-' . $y . '-columns'])){
          update_post_meta($post_id, 'row-' . $y . '-columns', sanitize_text_field($_POST['row-' . $y . '-columns']));
        }
      }
    }
  }
  add_action( 'save_post', 'dwwp_meta_save' );

?>
