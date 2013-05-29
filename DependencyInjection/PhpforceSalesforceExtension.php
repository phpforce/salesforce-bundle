<?php

namespace Phpforce\SalesforceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PhpforceSalesforceExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('soap_client.xml');
        $loader->load('rest_client.xml');
        foreach ($config['soap_client'] as $key => $value) {
            $container->setParameter('phpforce.soap_client.' . $key, $value);
        }

        if (true == $config['soap_client']['logging']) {
            $builder = $container->getDefinition('phpforce.soap_client.builder');
//            $builder->addMethodCall('withLog', array(new Reference('phpforce_salesforce.logger')));
        }
    }


}
