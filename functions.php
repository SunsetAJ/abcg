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

    $numAvailableCol = 12;

    wp_nonce_field(basename( __FILE__ ), 'acbg_nonce');
    $acbg_stored_meta = get_post_meta( $post->ID );
    ?>
      <!-- Caption of the Meta Box -->
      <h3 style="margin-bottom: 0px;">Add a new Bootstrap Grid:</h3>
      <small>* Once you have selected a NEW value press the update button *</small>
      <small style="margin-bottom: 15px; display: block;">* Bootstrap css & js is required for this to work *</small>
      <div class="form-elements">

        <!-- Container Type -->
        <div style="margin-bottom: 20px;" class="container-type">
          <label for="containerType"><?php _e('Container Type *Default is normal*', 'treehouse_wp') ?></label>
          <select name="containerType" id="containerType">
            <option value="Normal" <?php if (! empty($acbg_stored_meta['containerType'])) selected($acbg_stored_meta['containerType'][0], 'Normal'); ?>><?php _e('Normal', 'treehouse_wp') ?></option>';
            <option value="Fluid" <?php if (! empty($acbg_stored_meta['containerType'])) selected($acbg_stored_meta['containerType'][0], 'Fluid'); ?>><?php _e('Fluid', 'treehouse_wp') ?></option>';
          </select>
        </div>

        <!-- Number of Rows -->
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
        </div>

        <!-- Number of Columns - based of number of rows -->
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
                    <?php
                      for ($xy = 1; $xy <= $numAvailableCol; $xy++){
                        ?> <option value="<?php echo $xy ?>" <?php if ( ! empty ( $acbg_stored_meta['row-' . $x . '-columns'] ) ) selected( $acbg_stored_meta['row-' . $x . '-columns'][0], $xy ); ?>><?php _e( $xy, 'treehouse_wp' )?></option>'; <?php
                      }
                    ?>
                  </select>
                </div>
              <?php
            }
            ?>
              </div>
            <?php
          }
        ?>

        <!-- Display Column Edit Area -->
        <?php
          if ($num >= 1){
            ?>
            <div style="margin-bottom: 20px;">
            <h3 style="margin-bottom:0px;">Enter the Classes for each of the columns</h3>
            <small style="margin-bottom: 15px; display: block;">* Separate Classes with a SPACE. These can also be custom classes *</small>
            <?php
            for ($i = 1; $i <= $num; $i++){
              ${'row-' . $i . '-columnCount'} = get_post_meta($post->ID, 'row-' . $i . '-columns', true);
              for ($iy = 1; $iy <= ${'row-' . $i . '-columnCount'}; $iy++){
                ?>
                  <label for="<?php echo 'row'.$i.'column'.$iy ?>"><?php _e('Row '. $i . ' Column ' . $iy . ' Class:', 'treehouse_wp') ?></label>
                  <input type="text" name="<?php echo 'row'.$i.'column'.$iy ?>" value="<?php
                    if (! empty($acbg_stored_meta['row'.$i.'column'.$iy.''])){
                      echo esc_attr($acbg_stored_meta['row'.$i.'column'.$iy.''][0]);
                    }
                  ?>">
                <?php
                echo '<br>';
              }
              echo '<br>';
            }
            ?>
            </div>
            <?php
          }
        ?>

      </div>
    <?php
    $content = '<table class="abcg-table" style="width: 100%;">';
                  $rows = 1;
                  for($rowCount = 1; $rowCount <= $num; $rowCount++){
                    $content .= '<tr class="row abgc-row-'.$rowCount.'">';
                      ${'row-'.$rowCount.'-columnCount'} = get_post_meta($post->ID, 'row-'.$rowCount.'-columns', true);
                      for ($colCount = 1; $colCount <= ${'row-'.$rowCount.'-columnCount'}; $colCount++){
                        $content .= '<th>Column ' . $colCount . '</th>';
                      }
                    $content .= '</tr>';
                  }
                $content .= '</table>';

    wp_editor($content, 'table-area');
  }

  /**
  * @param int $post_id Post ID
  */
  function dwwp_meta_save( $post_id ) {
    $num = 6;
    $numAvailableCol = 12;
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

    //This is also be interesting
    if ($num >= 1){
      for ($h = 1; $h <= $num; $h++){
        for($hg = 1; $hg <= $numAvailableCol; $hg++){
          if (isset($_POST['row'.$h.'column'.$hg.''])){
            update_post_meta($post_id,'row'.$h.'column'.$hg.'', sanitize_text_field($_POST['row'.$h.'column'.$hg.'']));
          }
        }
      }
    }

  }
  add_action( 'save_post', 'dwwp_meta_save' );

?>
