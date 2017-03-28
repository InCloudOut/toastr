<?php
namespace InCloudOut\Toastr\Tests;

use InCloudOut\Toastr\Toastr;
use Orchestra\Testbench\TestCase;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Session\SessionManager;
use Mockery as m;

abstract class AbstractTest extends TestCase
{

    protected $session;

    protected $config;

    protected $toastr;

    public function setUp()
    {
        parent::setUp();
        $this->session = $this->app->session;
        $this->config = $this->app->config;
        $this->toastr = new Toastr($this->session, $this->config);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('toastr', [
            'session'   => true,
            'maps'      => [
                'success'   => 'success',
                'warning'   => 'warning',
                'error'     => 'error',
                'info'      => 'info',
                'message'   => 'info',
            ],
            'options'   => [
                'closeButton'       => true,
                'debug'             => false,
                'newestOnTop'       => false,
                'progressBar'       => false,
                'positionClass'     => 'toast-top-right',
                'preventDuplicates' => false,
                'onclick'           => null,
                'showDuration'      => '300',
                'hideDuration'      => '1000',
                'timeOut'           => '5000',
                'extendedTimeOut'   => '1000',
                'showEasing'        => 'swing',
                'hideEasing'        => 'linear',
                'showMethod'        => 'fadeIn',
                'hideMethod'        => 'fadeOut'
            ],
        ]);
    }

}