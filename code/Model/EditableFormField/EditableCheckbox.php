<?php

namespace SilverStripe\UserForms\Model\EditableFormField;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\UserForms\Model\EditableFormField;

/**
 * EditableCheckbox
 *
 * A user modifiable checkbox on a UserDefinedForm
 *
 * @package userforms
 */

class EditableCheckbox extends EditableFormField
{
    private static $singular_name = 'Checkbox Field';

    private static $plural_name = 'Checkboxes';

    protected $jsEventHandler = 'click';

    private static $db = [
        'CheckedDefault' => 'Boolean' // from CustomSettings
    ];

    private static $table_name = 'EditableCheckbox';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField('Default', CheckboxField::create(
            "CheckedDefault",
            _t('SilverStripe\\UserForms\\Model\\EditableFormField.CHECKEDBYDEFAULT', 'Checked by Default?')
        ));

        return $fields;
    }

    public function getFormField()
    {
        $field = CheckboxField::create($this->Name, $this->EscapedTitle, $this->CheckedDefault)
            ->setFieldHolderTemplate(__CLASS__ . '_holder')
            ->setTemplate(__CLASS__);

        $this->doUpdateFormField($field);

        return $field;
    }

    public function getValueFromData($data)
    {
        $value = (isset($data[$this->Name])) ? $data[$this->Name] : false;

        return ($value)
            ? _t('SilverStripe\\UserForms\\Model\\EditableFormField.YES', 'Yes')
            : _t('SilverStripe\\UserForms\\Model\\EditableFormField.NO', 'No');
    }

    public function migrateSettings($data)
    {
        // Migrate 'Default' setting to 'CheckedDefault'
        if (isset($data['Default'])) {
            $this->CheckedDefault = (bool)$data['Default'];
            unset($data['Default']);
        }

        parent::migrateSettings($data);
    }

    public function isCheckBoxField()
    {
        return true;
    }
}
