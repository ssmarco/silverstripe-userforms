<?php

namespace SilverStripe\UserForms\Model\EditableFormField;

use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\Forms\DropdownField;
use SilverStripe\i18n\i18n;
use SilverStripe\UserForms\Model\EditableCustomRule;
use SilverStripe\UserForms\Model\EditableDropdownField;
use SilverStripe\UserForms\Model\EditableFormField;

/**
 * A dropdown field which allows the user to select a country
 *
 * @package userforms
 */
class EditableCountryDropdownField extends EditableFormField
{
    private static $singular_name = 'Country Dropdown';

    private static $plural_name = 'Country Dropdowns';

    private static $table_name = 'EditableCountryDropdownField';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Default');

        return $fields;
    }

    public function getFormField()
    {
        $field = DropdownField::create($this->Name, $this->EscapedTitle)
            ->setSource(i18n::getData()->getCountries())
            ->setFieldHolderTemplate('UserFormsField_holder')
            ->setTemplate(EditableDropdownField::class);

        $this->doUpdateFormField($field);

        return $field;
    }

    public function getValueFromData($data)
    {
        if (isset($data[$this->Name])) {
            $source = $this->getFormField()->getSource();
            return $source[$data[$this->Name]];
        }
    }

    public function getIcon()
    {
        return ModuleLoader::getModule('silverstripe/userforms')
            ->getRelativeResourcePath('images/editabledropdown.png');
    }

    public function getSelectorField(EditableCustomRule $rule, $forOnLoad = false)
    {
        return "$(\"select[name='{$this->Name}']\")";
    }
}
