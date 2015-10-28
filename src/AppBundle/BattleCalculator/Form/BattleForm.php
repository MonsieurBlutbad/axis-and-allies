<?php
/**
 * Created by PhpStorm.
 * User: Kay
 * Date: 25.10.2015
 * Time: 10:29
 */

namespace AppBundle\BattleCalculator\Form;

use AppBundle\BattleCalculator\Calculation;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class BattleForm
{
    /**
     * var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var FormView
     */
    protected $formView;

    /**
     * @var Calculation
     */
    protected $result;

    /**
     * @param $type
     */
    function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param Form $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * @return Calculation
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Calculation $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return FormView
     */
    public function getFormView()
    {
        return $this->formView;
    }

    /**
     * @param FormView $formView
     */
    public function setFormView($formView)
    {
        $this->formView = $formView;
    }

}