$(function () {

    $('#formmapper').popover({'trigger': 'focus'});

    $('input:disabled').val('Add location above');

    $.widget('custom.myAutocomplete', $.ui.autocomplete, {
        _renderItem: function (ul, item) {
            var link = $('<a>')
                .append($('<div>').addClass(item.itemIconClass))
                .append(highlight(item.value, $('#formmapper').val()))
                .append($('<div>').addClass(item.logoClass));

            return $("<li>").addClass("ui-menu-item").append(link).appendTo(ul);
        }
    });

    var Application = new App();

    $("#findMe").click(function () {
        Application.findMe();
    });

    $("#formmapper").myAutocomplete({

        source: function (request, response) {
            Application.resetAutocompleteVariants();
            Application.getAutocompleteVariantsFromGoogle(request.term, response);
            Application.getAutocompleteVariantsFromLocName(request.term, response);

        },

        select: function (event, ui) {
            var item = ui.item;
            if (item.autocompleteType === 'google') {
                Application.selectGoogleAutocompleteVariant(item);
            }
            if (item.autocompleteType === 'locName') {
                Application.selectLocNameAutocompleteVariant(item);
            }
        },
        autoFocus: true
    });

    $('#checkbox_email').click(function () {
        if ($('#checkbox_email').prop('checked')) {
            $('#sender_email_div').show();
        }
        else {
            $('#sender_email_div').hide();
        }

    });

});

function highlight(all_text, highlight_text) {
    return all_text.replace(new RegExp(highlight_text, 'gi'), function (matched) {
            return "<span class='ui-autocomplete-term'>%s</span>".replace('%s', matched);
        }
    );
}
