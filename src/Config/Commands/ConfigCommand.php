<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Config\Commands;

use Laradic\Commands\BaseCommand;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigCommand extends BaseCommand
{

    protected $signature = 'config
                            {key? : (Optional) The configuration key}
                            {val? : (Optional) The value to set the configuration item}
                            {--debug : This will enable configuration of hidden items}
                            {--unset : Removes a configuration item completely, if there was a default value it will be set instead}';

    protected $description = 'Configure global config options';


    protected function configure()
    {
        $this->setHelp(<<<EOT
<info>List</info> all config setting:

    <comment>%command.bin%</comment>

<info>Read</info> a config setting:

    <comment>%command.bin% projects.config_filename</comment>
    Outputs: <info>.sebwite.php</info>

<info>Add/edit</info> a config setting:

    <comment>%command.bin% projects.config_filename .project.php</comment>

<info>Unset/reset</info> a configuration item to default, if there was a default value it will be set instead:

    <comment>%command.bin% projects.config_filename --unset </comment>

<info>Debug</info> enables configuration of hidden items:
    <comment>%command.bin% --debug</comment>
    <comment>%command.bin% swcli.projects.config_filename .project.php --debug</comment>
EOT
        );
    }

    public function handle()
    {
        $key = $this->argument('key');
        $val = $this->argument('val');

//        if ( !$this->option('debug') )
//        {
//            if ( $this->argument('key') )
//            {
//                $key = ".{$key}";
//            }
//            $key = "swcli{$key}";
//        }

        if ( $this->option('unset') )
        {
            cli()->forget($key);
        }
        elseif ( $val === null )
        {
            $this->listConfig($key);
        }
        else
        {
            $this->editConfig($key, $val);
        }
    }

    protected function editConfig($key, $val)
    {

        if ( is_numeric($val) )
        {
            $val = (int)$val;
        }
        if ( $val === 'true' || $val === 'false' )
        {
            $val = $val === 'true';
        }
        if ( $val === 'null' )
        {
            $val = null;
        }

        cli()->set($key, $val);
        $this->comment("Changed [{$key}] to [{$val}] and saved to database");
    }

    protected function listConfig($key)
    {
        #$config = cli()->config();

        if ( $key !== null )
        {
            if ( !cli()->has($key) )
            {
                return $this->error("Config key [{$key}] does not exist");
            }

            $config = cli()->get($key);
        }
        else
        {
            $config = cli()->get();
        }
        if ( !is_array($config) )
        {
            $config = [ $key => $config ];
        }
        foreach ( array_dot($config) as $key => $value )
        {
            $this->output->writeln('[<comment>' . $key . '</comment>] <info>' . $value . '</info>');
        }
    }

    protected function key()
    {
        $key = $this->argument('key');
        if ( $key === null )
        {
            return '';
        }

        return $key;
    }

    protected function listConfiguration(array $contents, array $rawContents, OutputInterface $output, $k = null)
    {
        $origK = $k;
        foreach ( $contents as $key => $value )
        {
            if ( $k === null && !in_array($key, [ 'config', 'repositories' ]) )
            {
                continue;
            }
            $rawVal = isset($rawContents[ $key ]) ? $rawContents[ $key ] : null;
            if ( is_array($value) && (!is_numeric(key($value)) || ($key === 'repositories' && null === $k)) )
            {
                $k .= preg_replace('{^config\.}', '', $key . '.');
                $this->listConfiguration($value, $rawVal, $output, $k);
                $k = $origK;
                continue;
            }
            if ( is_array($value) )
            {
                $value = array_map(function ($val)
                {

                    return is_array($val) ? json_encode($val) : $val;
                }, $value);
                $value = '[' . implode(', ', $value) . ']';
            }
            if ( is_bool($value) )
            {
                $value = var_export($value, true);
            }
            if ( is_string($rawVal) && $rawVal != $value )
            {
                $output->writeln('[<comment>' . $k . $key . '</comment>] <info>' . $rawVal . ' (' . $value . ')</info>');
            }
            else
            {
                $output->writeln('[<comment>' . $k . $key . '</comment>] <info>' . $value . '</info>');
            }
        }
    }
}
