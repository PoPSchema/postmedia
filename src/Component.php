<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostMedia;

use PoP\Root\Component\AbstractComponent;
use PoP\Root\Component\YAMLServicesTrait;
use PoP\ComponentModel\Container\ContainerBuilderUtils;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    use YAMLServicesTrait;
    // const VERSION = '0.1.0';

    public static function getDependedComponentClasses(): array
    {
        return [
            \PoPSchema\CustomPosts\Component::class,
            \PoPSchema\Media\Component::class,
            \PoPSchema\BasicDirectives\Component::class,
        ];
    }

    public static function getDependedMigrationPlugins(): array
    {
        return [
            'pop-schema/migrate-custompostmedia',
        ];
    }

    /**
     * Initialize services
     */
    protected static function doInitialize(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        parent::doInitialize($configuration, $skipSchema, $skipSchemaComponentClasses);
        self::maybeInitYAMLSchemaServices(dirname(__DIR__), $skipSchema);
    }

    /**
     * Boot component
     *
     * @return void
     */
    public static function beforeBoot(): void
    {
        parent::beforeBoot();

        // Initialize classes
        ContainerBuilderUtils::attachAndRegisterDirectiveResolversFromNamespace(__NAMESPACE__ . '\\DirectiveResolvers');
        ContainerBuilderUtils::attachFieldResolversFromNamespace(__NAMESPACE__ . '\\FieldResolvers');
        ContainerBuilderUtils::registerFieldInterfaceResolversFromNamespace(__NAMESPACE__ . '\\FieldInterfaceResolvers');
    }
}
