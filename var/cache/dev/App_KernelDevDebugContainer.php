<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerEmavF0u\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerEmavF0u/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerEmavF0u.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerEmavF0u\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerEmavF0u\App_KernelDevDebugContainer([
    'container.build_hash' => 'EmavF0u',
    'container.build_id' => '620d6f33',
    'container.build_time' => 1685314023,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerEmavF0u');
