/**
 * Created by Kay on 28.10.2015.
 */

$(function()
{
    var $typeSelect = $('#battle_form_type');

    var $formGroups = {
        land_battle: $('input.land_battle').parent('div.form-group'),
        amphibious_assault: $('input.amphibious_assault').parent('div.form-group'),
        sea_battle:  $('input.sea_battle').parent('div.form-group')
    };

    var $form = $('form.battle-calculator-form');

    updateFields();

    /**
     * Updates form fields when the type select field changes.
     */
    $typeSelect.change(
        function()
        {
            updateFields();
        }
    );

    /**
     * Clears unrequired form fields when the form is submitted.
     */
    $form.submit(
        function(e)
        {
            var type = $typeSelect[0].value;
            var $unitInputs = $(
                'input.land_battle:not(.' + type + '), ' +
                'input.amphibious_assault:not(.' + type + '), ' +
                'input.sea_battle:not(.' + type + ')'
            );
            for(var index in $unitInputs) {
                $unitInputs[index].value = 0;
            }
        }
    );

    /**
     * Updates the form to display only fields that match the battle type.
     */
    function updateFields()
    {
        for(var type in $formGroups)
            $formGroups[type].hide();
        $formGroups[$typeSelect[0].value].show();

    }



});