<?php

namespace Cwca\PretendButton;

use Laravel\Nova\Fields\Field;

class PretendButton extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'pretend-button';

    public function setUserID($id)
    {
        return $this->withMeta(['user_id' => $id]);
    }
}
