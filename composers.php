<?php

View::composer('core::partials.sidebar-nav', 'Modules\Menu\Composers\SidebarViewComposer');
View::composer('partials.navigation', 'Modules\Menu\Composers\NavigationViewComposer');
