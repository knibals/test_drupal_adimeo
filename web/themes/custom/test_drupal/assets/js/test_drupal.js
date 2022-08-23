/**
 * @file
 * Drupal behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.test_drupal = {
    attach: function (context, settings) {
      console.log('It works!');
    }
  };

} (Drupal));
