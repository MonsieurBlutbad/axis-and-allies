/**
 * Created by Kay on 28.10.2015.
 */

$(function()
{
    var $typeSelect = $('#battle_form_type');

    var formGroups = {
        land_battle: $('input.land_battle').parent('div.form-group'),
        amphibious_assault: $('input.amphibious_assault').parent('div.form-group'),
        sea_battle:  $('input.sea_battle').parent('div.form-group')
    };

    var $form = $('form.battle-calculator-form');

    var $resetButton = $('#reset');

    var $swapButton = $('#swap');

    var unitInputs = {
        attacker : $('.attacker-units input'),
        defender: $('.defender-units input')
    };

    var metaInfos = {
        attacker: {
            units: $('.attacker-fieldset .meta-infos .meta-info-units'),
            ipcs: $('.attacker-fieldset .meta-infos .meta-info-ipcs'),
            battleValue: $('.attacker-fieldset .meta-infos .meta-info-battle-value'),
            hitPoints: $('.attacker-fieldset .meta-infos .meta-info-hit-points')
        },
        defender: {
            units: $('.defender-fieldset .meta-infos .meta-info-units'),
            ipcs: $('.defender-fieldset .meta-infos .meta-info-ipcs'),
            battleValue: $('.defender-fieldset .meta-infos .meta-info-battle-value'),
            hitPoints: $('.defender-fieldset .meta-infos .meta-info-hit-points')
        }
    };

    updateFields();

    updateMetaInfos();

    for(var side in unitInputs) {
        unitInputs[side].change(
            function()
            {
                updateMetaInfos();
            }
        )
    }

    /**
     * Updates form fields when the type select field changes.
     */
    $typeSelect.change(
        function()
        {
            updateFields();
            
            updateMetaInfos();
        }
    );

    /**
     * Clears unrequired form fields when the form is submitted.
     */
    $form.submit(
        function(e)
        {
            var type = $typeSelect[0].value;
            var unusedUnitInputs = $(
                'input.land_battle:not(.' + type + '), ' +
                'input.amphibious_assault:not(.' + type + '), ' +
                'input.sea_battle:not(.' + type + ')'
            );
            for(var index in unusedUnitInputs) {
                unusedUnitInputs[index].value = 0;
            }
        }
    );

    /**
     * Sets all unit input fields to null.
     */
    $resetButton.click(
        function(e)
        {
            e.preventDefault();

            for(var side in unitInputs) {
                for(var index in unitInputs[side]) {
                    unitInputs[side][index].value = null;
                }
            }

            updateMetaInfos();

        }
    );

    $swapButton.click(
        function(e)
        {
            e.preventDefault();

            unitInputs.attacker.each(
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
            );

            updateMetaInfos();
        }

    );

    /**
     * Updates the form to display only fields that match the battle type.
     */
    function updateFields()
    {
        for(var type in formGroups)
            formGroups[type].hide();
        formGroups[$typeSelect[0].value].show();

    }

    /**
     * Updates the form to display only fields that match the battle type.
     */
    function updateMetaInfos()
    {
        for(var side in metaInfos) {

            var units = 0;
            var ipcs = 0;
            var battleValue = 0;
            var hitPoints = 0;
            var attackerUnits = [];

            unitInputs[side].each(
                function(index, input)
                {
                    var $input = $(input);

                    // TODO
                    if($input.hasClass($typeSelect[0].value)
                        &&( ! ($typeSelect[0].value === 'amphibious_assault' && ! $input.hasClass('land_battle')))
                    ) {
                        units += Number($input.val());

                        if(! isNaN($input.data('cost'))) {
                            ipcs += Number ($input.data('cost')) * Number($input.val());
                        }

                        if(! isNaN($input.data('battle-value'))) {
                            battleValue += Number ($input.data('battle-value')) * Number($input.val());
                        }

                        if(! isNaN($input.data('hit-points'))) {
                            hitPoints += Number ($input.data('hit-points')) * Number($input.val());
                        }

                        if(side === 'attacker') {
                            console.log($input.data('name'));
                            attackerUnits[$input.data('name')] = Number($input.val());
                        }
                    }
                }

            );

            // TODO
            if(side === 'attacker') {
                battleValue += Math.min(
                    attackerUnits['infantry'] + attackerUnits['mechanized_infantry'],
                    attackerUnits['artillery']
                );
                battleValue += Math.min(
                    attackerUnits['tactical_bomber'],
                    attackerUnits['fighter'] + attackerUnits['tank']
                );
            }

            metaInfos[side].units.html(units);
            metaInfos[side].ipcs.html(ipcs);
            metaInfos[side].battleValue.html(battleValue);
            metaInfos[side].hitPoints.html(hitPoints);
        }
    }

});