{
    "providers": [
        "Laradic\\Foundation\\Providers\\FoundationServiceProvider",
        "Illuminate\\Cache\\CacheServiceProvider",
        "Illuminate\\Filesystem\\FilesystemServiceProvider",
        "Illuminate\\Pipeline\\PipelineServiceProvider",
        "Illuminate\\View\\ViewServiceProvider",
        "Sebwite\\Support\\SupportServiceProvider",
        "Laradic\\Providers\\ResourcesServiceProvider"
    ],
    "eager": [
        "Laradic\\Foundation\\Providers\\FoundationServiceProvider",
        "Illuminate\\Filesystem\\FilesystemServiceProvider",
        "Illuminate\\View\\ViewServiceProvider",
        "Sebwite\\Support\\SupportServiceProvider",
        "Laradic\\Providers\\ResourcesServiceProvider"
    ],
    "deferred": {
        "cache": "Illuminate\\Cache\\CacheServiceProvider",
        "cache.store": "Illuminate\\Cache\\CacheServiceProvider",
        "memcached.connector": "Illuminate\\Cache\\CacheServiceProvider",
        "command.cache.clear": "Illuminate\\Cache\\CacheServiceProvider",
        "Illuminate\\Contracts\\Pipeline\\Hub": "Illuminate\\Pipeline\\PipelineServiceProvider"
    },
    "when": {
        "Illuminate\\Cache\\CacheServiceProvider": [],
        "Illuminate\\Pipeline\\PipelineServiceProvider": []
    }
}