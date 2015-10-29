/**
 * Created by Kay on 28.10.2015.
 */

$(function()
{
    var $type = $('#battle_calculator_form_type');
    var $battleFields = {
        land_battle: $('input.land-battle'),
        amphibious_assault: $('input.amphibious-assault'),
        sea_battle:  $('input.sea-battle')
    };
    console.log('si');

    $type.change(
        function()
        {
            var type = this.value;
            console.log($battleFields[type]);
            $battleFields.each( function(battleFieldsByType, battleType) {
                console.log(battleType);
                battleFieldsByType.each( function(battleField) {

                })
            })
        }
    );


});