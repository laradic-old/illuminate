<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Support;


use Illuminate\Contracts\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Sebwite\Support\Filesystem;
use Sebwite\Support\Path;
use Sebwite\Support\Str;

class Blade
{
    /**
     * @var string
     */
    protected $cachePath;

    /**
     * @var BladeCompiler
     */
    protected $compiler;

    /**
     * @var \Sebwite\Support\Filesystem
     */
    protected $fs;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $viewFactory;

    public function __construct(Filesystem $fs, Factory $viewFactory = null, $cachePath = null)
    {
        $this->viewFactory = $viewFactory;
        $this->fs          = $fs;
        $cachePath         = $cachePath === null ? storage_path('blade') : $cachePath;
        $this->setCachePath($cachePath);
    }

    public function render($str, array $vars = [ ])
    {
        $__tmp_stub_file = Str::random() . uniqid(time(), false);
        ! $this->fs->exists($this->cachePath) && $this->fs->makeDirectory($this->cachePath, 0755, true);
        $__tmp_stub_path = Path::join($this->cachePath, $__tmp_stub_file);
        $this->fs->put($__tmp_stub_path, $this->compiler->compileString($str));

        $__env = $this->getViewFactory();
        if ( is_array($vars) && 0 !== count($vars) ) {
            extract($vars);
        }

        ob_start();
        include($__tmp_stub_path);
        $var = ob_get_contents();
        ob_end_clean();

        $this->fs->delete($__tmp_stub_path);

        return $var;
    }

    /**
     * Set the cachePath value
     *
     * @param mixed $cachePath
     *
     * @return Blade
     */
    public function setCachePath($cachePath)
    {
        $this->cachePath = $cachePath;
        $this->compiler  = new BladeCompiler(Filesystem::create(), $this->cachePath);

        return $this;
    }

    /**
     * Set the fs value
     *
     * @param Filesystem $fs
     *
     * @return Blade
     */
    public function setFs($fs)
    {
        $this->fs = $fs;

        return $this;
    }

    /**
     * @return Factory
     */
    public function getViewFactory()
    {
        return $this->viewFactory;
    }

    /**
     * Set the viewFactory value
     *
     * @param Factory $viewFactory
     *
     * @return Blade
     */
    public function setViewFactory($viewFactory)
    {
        $this->viewFactory = $viewFactory;

        return $this;
    }




}
