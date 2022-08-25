/**
 * @file
 * Drupal behaviors.
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.test_drupal = {
    attach: function (context, settings) {

      // Voir http://api.jqueryui.com/dialog/ pour toutes les options disponibles.
      var box = Drupal.dialog($('#similars'), {
        width: 800,
        title: 'Évènements similaires',
        closeOnEscape: true,
        closeText: "hide",
      });

      $('#open-lightbox').click(function(){
        box.showModal();
      });
    }
  };

} (jQuery, Drupal));
