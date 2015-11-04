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

    var $reset = $('#reset');

    var $swap = $('#swap');

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
     * Sets all unit input fields to null.
     */
    $reset.click(
        function(e)
        {
            e.preventDefault();

            var $unitInputs = $(
                'input.land_battle, input.amphibious_assault, input.sea_battle'
            );

            for(var index in $unitInputs) {
                $unitInputs[index].value = null;
            }
        }
    );

    $swap.click(
        function(e)
        {
            e.preventDefault();

            var $attackingUnits = $('.attacker-units input');

            $attackingUnits.each(
                function()
                {
                    var $attackingUnit = $(this);
                    var name = $attackingUnit.data('name');
                    var $defendingUnit = $('.defender-units input[data-name="' + name + '"]');
                    if($defendingUnit) {
                        var attackingUnitValue = $attackingUnit.val();
                        $attackingUnit.val($defendingUnit.val());
                        $defendingUnit.val(attackingUnitValue);
                    }
                }
            )
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