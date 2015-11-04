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
            battleValue: $('.attacker-fieldset .meta-infos .meta-info-battle-value')
        },
        defender: {
            units: $('.defender-fieldset .meta-infos .meta-info-units'),
            ipcs: $('.defender-fieldset .meta-infos .meta-info-ipcs'),
            battleValue: $('.defender-fieldset .meta-infos .meta-info-battle-value')
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
            )

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
            metaInfos[side].units.html(getMetaInfoUnits(side));
            metaInfos[side].ipcs.html(getMetaInfoIPCs(side));
            metaInfos[side].battleValue.html(getMetaInfoBattleValue(side));
        }
    }

    /**
     *
     */
    function getMetaInfoUnits(side)
    {
        var units = 0;
        unitInputs[side].each(
            function(index, input)
            {
                var $input = $(input);
                if($input.hasClass($typeSelect[0].value)) {
                    units += Number($input.val());
                }
            }
        );
        return units;
    }

    /**
     *
     */
    function getMetaInfoIPCs(side)
    {
        var ipcs = 0;
        unitInputs[side].each(
            function(index, input)
            {
                var $input = $(input);
                if($input.hasClass($typeSelect[0].value)) {
                    if(! isNaN($input.data('cost'))) {
                        ipcs += Number ($input.data('cost')) * Number($input.val());
                    }
                }

            }
        );
        return ipcs;
    }


    /**
     *
     */
    function getMetaInfoBattleValue(side)
    {
        var battleValue = 0;
        unitInputs[side].each(
            function(index, input)
            {
                var $input = $(input);
                if($input.hasClass($typeSelect[0].value)) {
                    if(! isNaN($input.data('battle-value'))) {
                        battleValue += Number ($input.data('battle-value')) * Number($input.val());
                    }
                }

            }
        );
        return battleValue;
    }



});