<?php
$selectors    = ['Exact match all parameters in any order', 'Ignore all parameters', 'Ignore & pass parameters to the target',];
?>

<div id="pop-up-add-redirection" class="rp-add-rule-block d-none">

  <div class="rp-add-rule-block--area">

    <!-- Title -->
    <div class="rp-add-rule-block-title">
      <h3 class="no-select">Add new redirection</h2>
      <span class="no-select tb-add-rule-btn--close" id="rp-add-rule-block-close">X</span>
    </div>

    <!-- Form -->
    <div class="rp-add-rule-block-form">

      <!-- Source URL -->
      <div class="rp-input">
          <label for="rp-source-url no-select"><img id="source_good" class="hidden" height="10" width="10" src="<?= PLUGIN_URL ?>/assets/icons/good.svg" alt="Success"><img id="source_error" class="hidden" height="10" width="10" src="<?= PLUGIN_URL ?>/assets/icons/bad.svg" alt="Error">Source URL <span id="error-source-exist" class="hidden">(already exist)</span></label>
          <div class="rp-source-url-input-container">
            <span class="input-group-addon no-select"><?= get_site_url() ?>/</span>
            <input class="rp-input-text" type="text" name="rp-source-url" id="rp-source-url" placeholder="contact-support/developers/">
          </div>
          <p class="rp-description"></p>
      </div>

      <!-- Target URL -->
      <div class="rp-input">
          <label for="rp-target-url"><img id="target_good" class="hidden" height="10" width="10" src="<?= PLUGIN_URL ?>/assets/icons/good.svg" alt="Success"><img id="target_error" class="hidden" height="10" width="10" src="<?= PLUGIN_URL ?>/assets/icons/bad.svg" alt="Error">Target URL</label>
          <input class="rp-input-text" type="url" name="rp-target-url" id="rp-target-url" placeholder="https://etorox.github.io/docs/">
          <p class="rp-description"></p>
      </div>

      <!-- Query Parameters -->
      <div class="rp-radio">
        
        <h4 class="no-select">Query Parameters</h4>

        <ul class="rb-radio-list"> <?php
          for ($i=0; $i < count($selectors); $i++) { ?>
            <li class="rb-radio-item">
              <input type="radio" name="query-parameters" value="<?= $i ?>" id="query-parameters--<?= $i ?>" <?= $i === count($selectors)-1 ? 'checked' : '' ?>>
              <label class="no-select" for="query-parameters--<?= $i ?>"><?= $selectors[$i] ?></label>
            </li>
          <?php } ?></ul> <!-- .rb-radio-list -->

      </div><!-- .rp-radio -->

      <div id="rp-submit-add-new-icon" class="rp-submit no-select">Add new redirection</div>

    </div> <!-- .rp-add-rule-block-form -->

  </div> <!-- .pp-add-rule-block--area -->

</div> <!-- .rp-add-rule-block -->