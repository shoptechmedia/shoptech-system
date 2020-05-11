<?php
/**
 * 2008 - 2018 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 * @version    3.7.6
 
 */

class Dispatcher extends DispatcherCore
{
	protected function loadRoutes()
	{
		foreach (Module::getModulesDirOnDisk() as $module)
			if (Module::isInstalled($module))
			{
				$content = Tools::file_get_contents(_PS_MODULE_DIR_.$module.'/'.$module.'.php');
				$pattern = '#\W((abstract\s+)?class|interface)\s+(?P<classname>'.basename($module, '.php')
					.'(Core)?)(\s+extends\s+[a-z][a-z0-9_]*)?(\s+implements\s+[a-z][a-z0-9_]*(\s*,\s*[a-z][a-z0-9_]*)*)?\s*\{#i';
				if (preg_match($pattern, $content, $m))
				{
					$class_name = $m['classname'];
					require_once( _PS_MODULE_DIR_.$module.'/'.$module.'.php' );
					if (method_exists($class_name, 'hookModuleRoutes'))
					{
						$module_route = new $class_name;
						foreach ($module_route->hookModuleRoutes() as $routes)
							array_push($this->default_routes, $routes);
					}
				}
			}
		parent::loadRoutes();
	}
}
