<?php

interface SettingsInterface
{
    public function get(string $key, $default = null);
}

interface LoggerInterface
{
    public function log(string $message);
}

class Logger implements LoggerInterface
{
    public function log(string $message)
    {
        var_dump($message);
    }
}

class GlobalSettings implements SettingsInterface
{
    public function get(string $key, $default = null)
    {
        return [$key => $default];
    }
}

class Option
{
    private $options;

    public function __construct()
    {
        $this->options = [
            'key1' => '6',
            'key2' => '5',
            'uploads_use_yearmonth_folders' => '10',
        ];
    }

    public function getOptions(string $key)
    {
        return $this->options[$key] ?? 'default';
    }
}

class SettingsRepository implements SettingsInterface
{
    private $settings;
    private $globalSettings;
    private $logger;
    private $options;

    public function __construct(GlobalSettings $globalSettings, Option $options, Logger $logger)
    {
        $this->globalSettings = $globalSettings;
        $this->options= $options;
        $this->logger = $logger;
        $this->settings = [
            'use-yearmonth-folders' => '2',
            'wp-uploads' => '1',
            'copy-to-s3' => '2',
            'serve-from-s3' => '3',
            'object-prefix' => '4',
            'object-versioning' => '1212',
        ];
    }

    public function get(string $key, $default = '')
    {
        if ((isset($this->settings['wp-uploads']) && $this->settings['wp-uploads'] && in_array($key, ['copy-to-s3', 'serve-from-s3'])) ||
        ('object-versioning' == $key && !isset($this->settings['object-versioning']))) {
            return $default;
        }

        if ('object-prefix' == $key && !isset($this->settings['object-prefix'])) {
            return $this->getDefaultObjectPrefix();
        }

        $this->logger->log('log message: step 3');

        if ('use-yearmonth-folders' == $key && !isset($this->settings['use-yearmonth-folders'])) {
            return $this->options->getOptions('uploads_use_yearmonth_folders');
        }

        $value = $this->globalSettings->get($key, $default);

        return $value[$key] ?? $default;
    }

    private function getDefaultObjectPrefix()
    {
        return 'get_default_object_prefix';
    }
}

