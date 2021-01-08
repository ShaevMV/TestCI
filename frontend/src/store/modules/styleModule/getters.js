/**
 * Вывести стиль для sidebar
 *
 * @param state
 *
 * @returns {string}
 */
export const getStyleForMainSideBar = state => {
    return state.openSidebar ? 'main-container' : 'main-container sidebar-closed sbar-open';
};


/**
 * Вывести стиль для main при открытие или закрытие SideBar
 *
 * @param state
 *
 * @returns {string}
 */
export const getStyleForMain = state => {
    return state.openSidebar ? 'alt-menu' : 'alt-menu sidebar-noneoverflow';
};

/**
 * Вывести стиль для NavBar при открытие или закрытие бокового меню
 *
 * @param state
 *
 * @returns {string}
 */
export const getStyleForNavBar = state => {
    return state.openSidebar ? 'header navbar navbar-expand-sm' : 'header navbar navbar-expand-sm expand-header';
};
