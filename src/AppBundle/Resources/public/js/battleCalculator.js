/**
 * Created by Kay on 28.10.2015.
 */

$(function()
{
    var $type = $('#battle_calculator_form_type');
    var $formGroups = {
        land_battle: $('input.land_battle').parent('div.form-group'),
        amphibious_assault: $('input.amphibious_assault').parent('div.form-group'),
        sea_battle:  $('input.sea_battle').parent('div.form-group')
    };

    var $unitInputs = $('input.land_battle, input.sea_battle, input.amphibious_assault');

    updateFields();

    $unitInputs.

    $type.change(
        function()
        {
            updateFields();
        }
    );

    function updateFields()
    {
        for(var type in $formGroups)
            $formGroups[type].hide();
        $formGroups[$type[0].value].show();

    }


});