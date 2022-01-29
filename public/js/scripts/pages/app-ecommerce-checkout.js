/*=========================================================================================
    File Name: app-ecommerce.js
    Description: Ecommerce pages js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// const { ajax } = require("jquery");

$(function () {
    'use strict';

    var quantityCounter = $('.quantity-counter'),
        CounterMin = 0,
        CounterMax = 1000,
        bsStepper = document.querySelectorAll('.bs-stepper'),
        checkoutWizard = document.querySelector('.checkout-tab-steps'),
        removeItem = $('.remove-wishlist'),
        update = $('.update'),
        isRtl = $('html').attr('data-textdirection') === 'rtl';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // update
    update.on('click', function () {
        $(this).text('Updating...');
        $.ajax({
            type: 'POST',
            url: '/update',
            data: {
                id: $(this).data('id'),
                price: $(this).closest('.quantity-counter').find('.quantity').val()
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr['success']('', 'Updated', {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl
                    });
                    $(this).text('Update');
                }
                else {
                    toastr['error']('', 'Error', {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl
                    });
                    $(this).text('Update');
                }
            }
        });
    });
    // remove items from wishlist page
    removeItem.on('click', function () {

        // add loading
        $(this).text('Removing...');

        // ajax
        $.ajax({
            url: '/admin/images/remove/file',
            type: 'POST',
            data: {
                id: $(this).attr('id')
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr['success']('', 'Removed Item 🗑️', {  // eslint-disable-line no-undef
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl
                    });
                    $('#image' + data.id + '').remove();
                } else {
                    toastr['error']('', 'Error 🙁', {  // eslint-disable-line no-undef
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl
                    });
                }
            }
        });

        // toastr['error']('', 'Removed Item 🗑️', {
        //     closeButton: true,
        //     tapToDismiss: false,
        //     rtl: isRtl
        // });
    });

    // move items to cart


    // Checkout Wizard

    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                // The first for loop is for increasing the steps,
                // the second is for turning them off when going back
                // and the third with the if statement because the last line
                // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to == 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
    }

    // Init Wizard
    if (typeof checkoutWizard !== undefined && checkoutWizard !== null) {
        var wizard = new Stepper(checkoutWizard, {
            linear: false
        });

        $(checkoutWizard)
            .find('.btn-next')
            .each(function () {
                $(this).on('click', function (e) {
                    wizard.next();
                });
            });

        $(checkoutWizard)
            .find('.btn-prev')
            .on('click', function () {
                wizard.previous();
            });
    }

    // checkout quantity counter
    if (quantityCounter.length > 0) {
        quantityCounter
            .TouchSpin({
                min: CounterMin,
                max: CounterMax
            })
            .on('touchspin.on.startdownspin', function () {
                var $this = $(this);
                $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
                if ($this.val() == 1) {
                    $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
                }
            })
            .on('touchspin.on.startupspin', function () {
                var $this = $(this);
                $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
                if ($this.val() == 10) {
                    $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
                }
            });
    }
});
