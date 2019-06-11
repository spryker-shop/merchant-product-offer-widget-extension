<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopUi\Twig;

use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Twig\TwigExtension;
use SprykerShop\Yves\ShopUi\Dependency\Client\ShopUiToTwigClientInterface;
use SprykerShop\Yves\ShopUi\ShopUiConfig;
use SprykerShop\Yves\ShopUi\Twig\Node\ShopUiDefineTwigNode;
use SprykerShop\Yves\ShopUi\Twig\TokenParser\ShopUiDefineTwigTokenParser;
use Twig\TwigFunction;

class ShopUiTwigExtension extends TwigExtension
{
    public const FUNCTION_GET_PUBLIC_FOLDER_PATH = 'publicPath';
    public const FUNCTION_GET_QA_ATTRIBUTE = 'qa';
    public const FUNCTION_GET_QA_ATTRIBUTE_SUB = 'qa_*';

    public const FUNCTION_GET_UI_MODEL_COMPONENT_TEMPLATE = 'model';
    public const FUNCTION_GET_UI_ATOM_COMPONENT_TEMPLATE = 'atom';
    public const FUNCTION_GET_UI_MOLECULE_COMPONENT_TEMPLATE = 'molecule';
    public const FUNCTION_GET_UI_ORGANISM_COMPONENT_TEMPLATE = 'organism';
    public const FUNCTION_GET_UI_TEMPLATE_COMPONENT_TEMPLATE = 'template';
    public const FUNCTION_GET_UI_VIEW_COMPONENT_TEMPLATE = 'view';
    public const DEFAULT_MODULE = 'ShopUi';

    protected const STORE_KEY = '%store%';
    protected const THEME_KEY = '%theme%';

    /**
     * @var \SprykerShop\Yves\ShopUi\ShopUiConfig
     */
    protected $shopUiConfig;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @var \SprykerShop\Yves\ShopUi\Dependency\Client\ShopUiToTwigClientInterface
     */
    protected $twigClient;

    /**
     * @param \SprykerShop\Yves\ShopUi\ShopUiConfig $shopUiConfig
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \SprykerShop\Yves\ShopUi\Dependency\Client\ShopUiToTwigClientInterface $twigClient
     */
    public function __construct(
        ShopUiConfig $shopUiConfig,
        Store $store,
        ShopUiToTwigClientInterface $twigClient
    ) {
        $this->shopUiConfig = $shopUiConfig;
        $this->store = $store;
        $this->twigClient = $twigClient;
    }

    /**
     * @return string[]
     */
    public function getGlobals(): array
    {
        return [
            'required' => ShopUiDefineTwigNode::REQUIRED_VALUE,
        ];
    }

    /**
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [];
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(self::FUNCTION_GET_PUBLIC_FOLDER_PATH, function ($relativePath) {
                $publicFolderPath = $this->getPublicFolderPath();

                return $publicFolderPath . $relativePath;
            }, [
                $this,
                self::FUNCTION_GET_PUBLIC_FOLDER_PATH,
            ]),

            new TwigFunction(self::FUNCTION_GET_QA_ATTRIBUTE, function (array $qaValues = []) {
                return $this->getQaAttribute($qaValues);
            }, [
                $this,
                self::FUNCTION_GET_QA_ATTRIBUTE,
                'is_safe' => ['html'],
                'is_variadic' => true,
            ]),

            new TwigFunction(self::FUNCTION_GET_QA_ATTRIBUTE_SUB, function ($qaName, array $qaValues = []) {
                return $this->getQaAttribute($qaValues, $qaName);
            }, [
                $this,
                self::FUNCTION_GET_QA_ATTRIBUTE_SUB,
                'is_safe' => ['html'],
                'is_variadic' => true,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_MODEL_COMPONENT_TEMPLATE, function ($modelName) {
                return $this->getModelTemplate($modelName);
            }, [
                $this,
                self::FUNCTION_GET_UI_MODEL_COMPONENT_TEMPLATE,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_ATOM_COMPONENT_TEMPLATE, function ($componentName, $componentModule = self::DEFAULT_MODULE) {
                return $this->getComponentTemplate($componentModule, 'atoms', $componentName);
            }, [
                $this,
                self::FUNCTION_GET_UI_ATOM_COMPONENT_TEMPLATE,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_MOLECULE_COMPONENT_TEMPLATE, function ($componentName, $componentModule = self::DEFAULT_MODULE) {
                return $this->getComponentTemplate($componentModule, 'molecules', $componentName);
            }, [
                $this,
                self::FUNCTION_GET_UI_MOLECULE_COMPONENT_TEMPLATE,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_ORGANISM_COMPONENT_TEMPLATE, function ($componentName, $componentModule = self::DEFAULT_MODULE) {
                return $this->getComponentTemplate($componentModule, 'organisms', $componentName);
            }, [
                $this,
                self::FUNCTION_GET_UI_ORGANISM_COMPONENT_TEMPLATE,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_TEMPLATE_COMPONENT_TEMPLATE, function ($templateName, $templateModule = self::DEFAULT_MODULE) {
                return $this->getTemplateTemplate($templateModule, $templateName);
            }, [
                $this,
                self::FUNCTION_GET_UI_TEMPLATE_COMPONENT_TEMPLATE,
            ]),

            new TwigFunction(self::FUNCTION_GET_UI_VIEW_COMPONENT_TEMPLATE, function ($viewName, $viewModule = self::DEFAULT_MODULE) {
                return $this->getViewTemplate($viewModule, $viewName);
            }, [
                $this,
                self::FUNCTION_GET_UI_VIEW_COMPONENT_TEMPLATE,
            ]),
        ];
    }

    /**
     * @return \Twig\TokenParser\AbstractTokenParser[]
     */
    public function getTokenParsers(): array
    {
        return [
            new ShopUiDefineTwigTokenParser(),
        ];
    }

    /**
     * @return string
     */
    protected function getPublicFolderPath(): string
    {
        return str_replace(
            [
                static::STORE_KEY,
                static::THEME_KEY,
            ],
            [
                $this->getStoreKey(),
                $this->getThemeKey(),
            ],
            $this->shopUiConfig->getYvesPublicFolderPathPattern()
        );
    }

    /**
     * @return string
     */
    protected function getThemeKey(): string
    {
        $themeName = $this->twigClient->getYvesThemeName();

        if (!$themeName) {
            $themeName = $this->twigClient->getYvesThemeNameDefault();
        }

        return strtolower($themeName);
    }

    /**
     * @return string
     */
    protected function getStoreKey(): string
    {
        return strtolower($this->store->getStoreName());
    }

    /**
     * @param array $qaValues
     * @param string|null $qaName
     *
     * @return string
     */
    protected function getQaAttribute(array $qaValues = [], ?string $qaName = null): string
    {
        $value = '';

        if (empty($qaValues)) {
            return '';
        }

        foreach ($qaValues as $qaValue) {
            if (!empty($qaValue)) {
                $value .= $qaValue . ' ';
            }
        }

        if (empty($qaName)) {
            return 'data-qa="' . trim($value) . '"';
        }

        return 'data-qa-' . $qaName . '="' . trim($value) . '"';
    }

    /**
     * @param string $modelName
     *
     * @return string
     */
    protected function getModelTemplate(string $modelName): string
    {
        return '@ShopUi/models/' . $modelName . '.twig';
    }

    /**
     * @param string $componentModule
     * @param string $componentType
     * @param string $componentName
     *
     * @return string
     */
    protected function getComponentTemplate(string $componentModule, string $componentType, string $componentName): string
    {
        return '@' . $componentModule . '/components/' . $componentType . '/' . $componentName . '/' . $componentName . '.twig';
    }

    /**
     * @param string $templateModule
     * @param string $templateName
     *
     * @return string
     */
    protected function getTemplateTemplate(string $templateModule, string $templateName): string
    {
        return '@' . $templateModule . '/templates/' . $templateName . '/' . $templateName . '.twig';
    }

    /**
     * @param string $viewModule
     * @param string $viewName
     *
     * @return string
     */
    protected function getViewTemplate(string $viewModule, string $viewName): string
    {
        return '@' . $viewModule . '/views/' . $viewName . '/' . $viewName . '.twig';
    }
}
