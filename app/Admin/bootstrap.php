<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

Encore\Admin\Form::extend('resetPasswordText', App\Admin\Form\ResetPasswordText::class);

\Encore\Admin\Facades\Admin::css('css/nprogress.css');
\Encore\Admin\Facades\Admin::js('js/nprogress.js');

$script = <<<SCRIPT
NProgress.configure({ parent: '#pjax-container' });
$(document).on('pjax:start', function() { NProgress.start(); });
$(document).on('pjax:end',   function() { NProgress.done();  });
SCRIPT;

\Encore\Admin\Facades\Admin::script($script);

\Encore\Admin\Facades\Admin::js('js/Chart.js');
