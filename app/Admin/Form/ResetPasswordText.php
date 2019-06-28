<?php

namespace App\Admin\Form;

use Encore\Admin\Form\Field;

class ResetPasswordText extends Field\Text
{
    /**
     * Render this filed.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->initPlainInput();

        $this->prepend('<i class="fa fa-pencil"></i>')
            ->defaultAttribute('type', 'text')
            ->defaultAttribute('id', $this->id)
            ->defaultAttribute('name', $this->elementName ?: $this->formatName($this->column))
            ->defaultAttribute('value', '点击重置密码')
            ->defaultAttribute('class', 'form-control '.$this->getElementClassString())
            ->defaultAttribute('placeholder', '输入密码');

        $this->script = <<<EOT
$("#{$this->id}").focus(function() {
    if ($(this).val() == '点击重置密码') {
        $(this).val('');
    }
}).blur(function() {
    if (!$(this).val()) {
        $(this).val('点击重置密码');
    }
});
EOT;

        return parent::render()->with([
            'prepend' => $this->prepend,
            'append'  => $this->append,
        ]);
    }
}
