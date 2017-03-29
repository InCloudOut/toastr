<?php

namespace InCloudOut\Toastr\Tests;


class ToastrTest extends AbstractTest
{
    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_error_toast()
    {
        $this->toastr->error('Error Message', 'Error');

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('error', $toastr['type']);
        $this->assertEquals('Error Message', $toastr['message']);
        $this->assertEquals('Error', $toastr['title']);
    }

    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_info_toast()
    {
        $this->toastr->info('Info Message', 'Info');

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('info', $toastr['type']);
        $this->assertEquals('Info Message', $toastr['message']);
        $this->assertEquals('Info', $toastr['title']);
    }

    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_success_toast()
    {
        $this->toastr->success('Success Message', 'Success');

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('success', $toastr['type']);
        $this->assertEquals('Success Message', $toastr['message']);
        $this->assertEquals('Success', $toastr['title']);
    }

    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_warning_toast()
    {
        $this->toastr->warning('Warning Message', 'Warning');

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('warning', $toastr['type']);
        $this->assertEquals('Warning Message', $toastr['message']);
        $this->assertEquals('Warning', $toastr['title']);
    }

    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_toast_based_on_session()
    {
        $this->app->config->set('toastr.session', true);

        $this->app->session->flash('success', 'Some Message');

        $output = $this->toastr->execute();

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('success', $toastr['type']);
        $this->assertEquals('Some Message', $toastr['message']);
    }

    /**
     * @group ToastrTest
     * @test
     */
    public function it_displays_toast_based_on_advanced_session()
    {
        $this->app->config->set('toastr.session', true);

        $this->app->session->flash('info', [
            'message'   => 'Info Message',
            'title'     => 'Some Title',
        ]);

        $output = $this->toastr->execute();

        $toastr = $this->session->get('toastr::toasts')[0];

        $this->assertEquals('info', $toastr['type']);
        $this->assertEquals('Info Message', $toastr['message']);
        $this->assertEquals('Some Title', $toastr['title']);
    }
}
