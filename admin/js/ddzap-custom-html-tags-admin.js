(function ($) {
  'use strict';

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(function () {

    /**
     * Variables
     *
     * @type {*|jQuery|HTMLElement}
     */
    var formSettings = $('form.ddzap-setting-form'),
      formId = formSettings.attr('id'),
      tag = formSettings.data('tag'),
      buttonUpdatePreview = $('#ddzap-button-update-preview'),
      buttonShowCSS = $('#ddzap-button-show-css'),
      buttonCopyCSS = $('#ddzap-button-copy-css'),
      buttonShowJS = $('#ddzap-button-show-js'),
      buttonCopyJS = $('#ddzap-button-copy-js'),
      styleBlock = $('pre.style-css'),
      scriptBlock = $('pre.script-js'),
      styleInputSetting = $('#' + formId + '-css'),
      scriptInputSetting = $('#' + formId + '-js'),
      iframePreview = $('#ddzap-iframe-preview');

    /**
     * Events
     */
    buttonUpdatePreview.on('click', updatePreviewWithStyle);

    buttonShowCSS.on('click', showCode);
    buttonCopyCSS.on('click', copyCode);

    buttonShowJS.on('click', showCode);
    buttonCopyJS.on('click', copyCode);

    formSettings.on('change', 'input', intervalUpdatePreview);

    $(document).on('ready', onReady);

    $('input[name*="color"]').wpColorPicker({
      change: intervalUpdatePreview
    });

    /**
     * Document Onload
     */
    function onReady() {
      if ($('#' + formId + '-enable').prop('checked')) {
        updatePreviewWithStyle();
      }
    }

    /**
     * Show Block PRE code
     */
    function showCode() {
      $(this).closest('.block').find('pre').fadeIn();
    }

    /**
     * Copy Block code
     */
    function copyCode() {
      copyToClipboard($(this).closest('.block').find('pre').text());
    }

    /**
     * Copy To Clipboard
     *
     * @param text
     */
    function copyToClipboard(text) {
      const el = document.createElement('textarea');
      el.value = text;
      document.body.appendChild(el);
      el.select();
      document.execCommand('copy');
      document.body.removeChild(el);
    }

    /**
     * Refresh Preview iFrame
     */
    function updatePreview() {

      iframePreview.animate({opacity: 0}, 200);

      iframePreview.get(0).contentWindow.location.reload();

      iframePreview.get(0).addEventListener('load', function () {
        iframePreview.animate({opacity: 1}, 200);
      });

    }

    /**
     * Refresh Preview iFrame with Style
     */
    function updatePreviewWithStyle() {

      var css = get_style(),
        js = get_script();

      styleBlock.html(css);
      scriptBlock.html(js);

      styleInputSetting.val(css);
      scriptInputSetting.val(js);

      updatePreview();

      iframePreview.get(0).onload = function () {
          iframePreview.contents().find("body").prepend('<style 123>' + css + '</style>');
          iframePreview.contents().find("input[type=" + tag + "]").wrap('<span class="ddzap-input-' + tag + '-container"></span>');
          iframePreview.contents().find("input[type=" + tag + "]").after('<span class="ddzap-input-' + tag + '"></span>');
      };

    }

    /**
     * Return CSS style by settings
     */
    function get_style() {
      var
        addStyle = '',
        textOffset = $('#' + formId + '-text-offset').val() || 5,
        width = $('#' + formId + '-width').val() || 20,
        height = $('#' + formId + '-height').val() || 20,
        top = $('#' + formId + '-offset-top').val() || 0,
        left = $('#' + formId + '-offset-left').val() || 0,
        borderWidth = $('#' + formId + '-border-width').val() || 1,
        borderRadius = $('#' + formId + '-border-radius').val() || 0,
        borderColor = $('#' + formId + '-border-color').val() || '#000000',
        flagWidth = $('#' + formId + '-flag-width').val() || 10,
        flagHeight = $('#' + formId + '-flag-height').val() || 10,
        flagBorderRadius = $('#' + formId + '-flag-border-radius').val() || 0,
        flagColor = $('#' + formId + '-flag-color').val() || '#000000';

      if ($('#' + formId + '-enable').prop('checked')) {

        if ( wc.active == 1 && tag === 'radio' ) {
          addStyle += "#payment .payment_methods > .woocommerce-PaymentMethod > label::before, #payment .payment_methods > .wc_payment_method > label::before {display: none !important}";
        }

        return addStyle + ".ddzap-input-" + tag + "-container {\n" +
          "  margin: 0 " + textOffset + "px 0 0 !important;\n" +
          "  display: inline-block !important;\n" +
          "  padding: 0 !important;\n" +
          "}\n" +
          ".ddzap-input-" + tag + "-container:before, .ddzap-input-" + tag + "-container:after {\n" +
          "  display: none !important;\n" +
          "}\n" +
          ".ddzap-input-" + tag + "-container input {\n" +
          "  display: none !important;\n" +
          "}\n" +
          ".ddzap-input-" + tag + "-container .ddzap-input-" + tag + " {\n" +
          "  position: relative !important;\n" +
          "  width: " + width + "px !important;\n" +
          "  height: " + height + "px !important;\n" +
          "  top: " + top + "px;\n" +
          "  left: " + left + "px;\n" +
          "  display: inline-block !important;\n" +
          "  padding: 0 !important;\n" +
          "  margin: 0 !important;\n" +
          "  border-radius: " + borderRadius + "px !important;\n" +
          "  border: " + borderWidth + "px solid " + borderColor + " !important;\n" +
          "}\n" +
          ".ddzap-input-" + tag + "-container input:checked + span:after {\n" +
          "  display: block !important;\n" +
          "  content: \"\";\n" +
          "  position: absolute !important;\n" +
          "  width: " + flagWidth + "px !important;\n" +
          "  height: " + flagHeight + "px !important;\n" +
          "  transform: translate(-50%, -50%) !important;\n" +
          "  top: 50% !important;\n" +
          "  left: 50% !important;\n" +
          "  border-radius: " + flagBorderRadius + "px !important;\n" +
          "  background-color: " + flagColor + " !important;\n" +
          "}\n" +
          ".ddzap-input-" + tag + "-container .ddzap-input-" + tag + ":after, .ddzap-input-" + tag + "-container .ddzap-input-" + tag + ":before {\n" +
          "  display: none !important;\n" +
          "}";
      }
    }

    /**
     * Get Script JS
     */
    function get_script() {
      var excludeClasses = $('#' + formId + '-exclude-classes').val().split(', ') || [],
          excludeClassesForIf = '1';

      if ( excludeClasses.filter((el) => {el !== ''}).length ) {
        excludeClassesForIf = excludeClasses.map((val) => "!inputs[i].classList.contains('" + val + "')").join(' && ');
      }

      return '' +
        "window.addEventListener('load', ddzapUpdateTag" + tag.charAt(0).toUpperCase() + tag.slice(1) + ", false);\n" +
        "function ddzapUpdateTag" + tag.charAt(0).toUpperCase() + tag.slice(1) + "() {\n" +
        "\tvar inputs = document.getElementsByTagName('input');\n" +
        "\tfor (var i = 0; i < inputs.length; i++) {\n" +
        "\t\tif (inputs[i].getAttribute('type') == '" + tag + "' && " +
        "!inputs[i].parentNode.classList.contains('ddzap-input-" + tag + "-container') && " +
        "" + excludeClassesForIf + " && " +
        "!inputs[i].closest('.wpcf7-form') && " +
        "!inputs[i].closest('.woocommerce-shipping-fields') && " +
        "!inputs[i].closest('.woocommerce-account-fields') && " +
        "!inputs[i].closest('.wc_payment_methods') && " +
        "!inputs[i].closest('.woocommerce-form__label') && " +
        "!inputs[i].closest('.woocommerce-shipping-methods') ) {\n" +
        "\t\t\tvar wrapper = document.createElement('span'),\n" +
        "\t\t\twrapperLabel = !inputs[i].closest('label') ? document.createElement('label') : '',\n" +
        "\t\t\tspan = document.createElement('span');\n" +
        "\t\t\tspan.classList.add('ddzap-input-" + tag + "');\n" +
        "\t\t\twrapper.classList.add('ddzap-input-" + tag + "-container');\n" +
        "\t\t\twrapper.innerHTML = inputs[i].outerHTML + '<span></span>';\n" +
        "\t\t\tinputs[i].parentNode.replaceChild(wrapper, inputs[i]);\n" +
        "\t\t\tif (!inputs[i].closest('label') && inputs[i].id && !document.querySelector('label[for=\"' + inputs[i].id + '\"]')) {wrapper.parentNode.insertBefore(wrapperLabel, wrapper);wrapperLabel.appendChild(wrapper);}" +
        "\t\t\tinputs[i].after(span);\n" +
        "\t\t}\n" +
        "\t}\n" +
        "};";
    }

    /**
     * Update Preview After some time
     */
    var intervalIdUpdatePreview;

    function intervalUpdatePreview() {

      clearInterval(intervalIdUpdatePreview);

      iframePreview.animate({opacity: 0}, 200);

      intervalIdUpdatePreview = setInterval(function () {
        updatePreviewWithStyle();
        clearInterval(intervalIdUpdatePreview);
      }, 500);
    }

  });
})(jQuery);
