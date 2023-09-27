'use strict';

const settingTabs = function () {
    const tabs = document.getElementById('settings-tab');
    if (!tabs) {
        return false;
    }
    const tabsContent = document.querySelectorAll('#settings-content .tab-content');

    const links = tabs.querySelectorAll('a');
    links.forEach((link) => {
        link.addEventListener('click', function () {
            const attr = link.getAttribute('data-tab');
            links.forEach(el => el.classList.remove('nav-tab-active'));
            tabsContent.forEach(el => el.classList.remove('tab-content-active'));
            link.classList.add('nav-tab-active');
            const tabContent = document.querySelector('[data-content=' + attr + ']');
            tabContent.classList.add('tab-content-active');
            setLocalStorage(attr);
        });
    });

    setTabs();

    function setTabs() {
        if (getLocalStorage() === '') {
            return false;
        }
        const tab = getLocalStorage();
        links.forEach(el => el.classList.remove('nav-tab-active'));
        tabsContent.forEach(el => el.classList.remove('tab-content-active'));
        const link = tabs.querySelector('a[data-tab="' + tab + '"]');
        link.classList.add('nav-tab-active');
        const cont = document.querySelector('[data-content=' + tab + ']');
        cont.classList.add('tab-content-active');
    }

    function setLocalStorage(attr) {
        sessionStorage.setItem("wowpTab", attr);
    }

    function getLocalStorage() {
        const tab = sessionStorage.getItem("wowpTab");
        if (!tab) {
            return ''
        } else {
            return tab;
        }
    }
}

const codeEditor = function () {
    const editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
    const codemirror_gen =
        {
            "indentUnit": 2,
            "indentWithTabs": true,
            "inputStyle": "contenteditable",
            "lineNumbers": true,
            "lineWrapping": true,
            "styleActiveLine": true,
            "continueComments": true,
            "extraKeys": {
                "Ctrl-Space": "autocomplete",
                "Ctrl-\/": "toggleComment",
                "Cmd-\/": "toggleComment",
                "Alt-F": "findPersistent",
                "Ctrl-F": "findPersistent",
                "Cmd-F": "findPersistent"
            },
            "direction": "ltr",
            "gutters": ["CodeMirror-lint-markers"],
            "lint": true,
            "autoCloseBrackets": true,
            "autoCloseTags": true,
            "matchTags": {
                "bothTags": true
            },
            "tabSize": 2,

        };

    const html_code = document.getElementById('html_code');
    if (html_code) {
        let codemirror_el =
            {
                "tagname-lowercase": true,
                "attr-lowercase": true,
                "attr-value-double-quotes": false,
                "doctype-first": false,
                "tag-pair": true,
                "spec-char-escape": true,
                "id-unique": true,
                "src-not-empty": true,
                "attr-no-duplication": true,
                "alt-require": true,
                "space-tab-mixed-disabled": "tab",
                "attr-unsafe-chars": true,
                "mode": 'htmlmixed',

            };

        editorSettings.codemirror = _.extend({}, editorSettings.codemirror, codemirror_gen, codemirror_el,);

        wp.codeEditor.initialize(html_code, editorSettings);
    }

    const css_code = document.getElementById('css_code');
    if (css_code) {
        let codemirror_el = {"mode": 'css',};
        editorSettings.codemirror = _.extend({}, editorSettings.codemirror, codemirror_gen, codemirror_el,);
        const tab = document.querySelector('[data-content="css-code"]');
        tab.classList.add('tab-content-active');
        wp.codeEditor.initialize(css_code, editorSettings);
        tab.classList.remove('tab-content-active');
    }

    const js_code = document.getElementById('js_code');
    if (js_code) {
        let codemirror_el = {
            "boss": true,
            "curly": true,
            "eqeqeq": true,
            "eqnull": true,
            "es3": true,
            "expr": true,
            "immed": true,
            "noarg": true,
            "nonbsp": true,
            "onevar": true,
            "quotmark": "single",
            "trailing": true,
            "undef": true,
            "unused": true,
            "browser": true,
            "globals": {
                "_": false,
                "Backbone": false,
                "jQuery": true,
                "JSON": false,
                "wp": false
            },
            "mode": 'javascript',
        };
        editorSettings.codemirror = _.extend({}, editorSettings.codemirror, codemirror_gen, codemirror_el,);
        const tab = document.querySelector('[data-content="js-code"]');
        tab.classList.add('tab-content-active');
        wp.codeEditor.initialize(js_code, editorSettings);
        tab.classList.remove('tab-content-active');
    }

}

const cloneIncludes = function () {

    const template = document.getElementById('clone-includes');
    if (!template) {
        return false;
    }

    const addBtn = document.getElementById('add-include');
    if (!addBtn) {
        return false;
    }

    addBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const clone = template.content.cloneNode(true);
        const targetElement = document.getElementById('includes-files');
        targetElement.appendChild(clone);
    });

}

const removeLast = function () {
    const btn = document.getElementById('remove-include');
    if (!btn) {
        return false;
    }

    btn.addEventListener('click', (event) => {
        event.preventDefault();
        const parentElement = document.getElementById('includes-files');
        const lastChild = parentElement.querySelector('.wowp-fields-group:last-child');
        if (lastChild) {
            lastChild.remove();
        }
    });


}

const changeIncludes = function () {
    const parentContainer = document.getElementById('includes-files');
    if (!parentContainer) {
        return false;
    }

    parentContainer.addEventListener('change', function (event) {

        // Check if the clicked element matches the desired selector
        if (event.target.matches('[name^="param[include]"]')) {
            const el = event.target.value;
            const parent = event.target.closest('.wowp-fields-group');
            const el_js = parent.querySelector('.wowp-include-js');
            el_js.classList.toggle('is-hidden');
        }
    });

}

const cloneDisplayRules = function () {

    const template = document.getElementById('clone-display-rules');
    if (!template) {
        return false;
    }

    const addBtn = document.getElementById('add-display');
    if (!addBtn) {
        return false;
    }

    addBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const clone = template.content.cloneNode(true);
        const container = document.getElementById('display-rules');
        const targetElement = document.querySelector('#display-rules .wowp-btn-actions');
        container.insertBefore(clone, targetElement);
    });

}

const removeDisplayRules = function () {
    const btn = document.getElementById('remove-display');
    if (!btn) {
        return false;
    }

    btn.addEventListener('click', (event) => {
        event.preventDefault();
        const parentElement = document.getElementById('display-rules');
        const lastChild = parentElement.querySelector('.wowp-fields-group:not(:first-child):nth-last-child(2)');
        if (lastChild) {
            lastChild.remove();
        }
    });

}

const changeDisplayRules = function () {
    const parentContainer = document.getElementById('display-rules');
    if (!parentContainer) {
        return false;
    }

    parentContainer.addEventListener('change', function (event) {

        // Check if the clicked element matches the desired selector
        if (event.target.matches('[name^="param[show]"]')) {
            let el = event.target.value;
            el = default_custom_post(el);
            const parent = event.target.closest('.wowp-fields-group');
            const elements = parent.querySelectorAll('.wowp-field');
            switch (el) {
                case 'shortcode':
                case 'everywhere':
                case 'post_all':
                case 'page_all':
                    elements[1].classList.add('is-hidden');
                    elements[2].classList.add('is-hidden');
                    elements[3].classList.add('is-hidden');
                    break;
                case 'post_selected':
                case 'post_category':
                case 'page_selected':
                    elements[1].classList.remove('is-hidden');
                    elements[2].classList.remove('is-hidden');
                    elements[3].classList.add('is-hidden');
                    break;
                case 'page_type':
                    elements[1].classList.remove('is-hidden');
                    elements[2].classList.add('is-hidden');
                    elements[3].classList.remove('is-hidden');
                    break;

            }

        }
    });

    function default_custom_post(el) {
        if (el.includes('custom_post_selected')) {
            return 'post_selected';
        }
        if (el.includes('custom_post_tax')) {
            return 'post_category';
        }
        if (el.includes('custom_post_all')) {
            return 'post_all';
        }
        return el;
    }

}

const userRoles = function () {
    const user = document.getElementById('item_user');
    if (!user) {
        return false;
    }
    const parent = user.closest('fieldset');

    user.addEventListener('change', (el) => {
        const role = user.value;
        const roles = parent.querySelector('.wowp-users-roles');
        if (parseInt(role) === 2) {
            roles.classList.remove('is-hidden');
        } else {
            roles.classList.add('is-hidden');
        }
    })

    const checkboxes = parent.querySelectorAll('input[type="checkbox"]');
    const role_all = document.getElementById('user_role_all');

    role_all.addEventListener('change', () => {
        if (role_all.checked) {
            checkboxes.forEach(el => el.checked = true);
        } else {
            checkboxes.forEach(el => el.checked = false);
        }
    });
}

const languages = function () {
    const depending = document.getElementById('depending_language');
    if (!depending) {
        return false;
    }
    const parent = depending.closest('fieldset');

    depending.addEventListener('change', () => {
        if (depending.checked) {
            parent.querySelector('.wowp-languages').classList.remove('is-hidden');
        } else {
            parent.querySelector('.wowp-languages').classList.add('is-hidden');
        }
    });
}

const schedule = function () {
    const schedule = document.getElementById('schedule');

    if (!schedule) {
        return false;
    }

    const template = document.getElementById('clone-schedule');
    const addBtn = document.getElementById('add-schedule');
    const removeBtn = document.getElementById('remove-schedule');

    addBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const clone = template.content.cloneNode(true);
        const container = document.getElementById('schedule');
        const targetElement = document.querySelector('#schedule .wowp-btn-actions');
        container.insertBefore(clone, targetElement);
    });

    removeBtn.addEventListener('click', (event) => {
        event.preventDefault();
        const parentElement = document.getElementById('schedule');
        const lastChild = parentElement.querySelector('.wowp-fields-group:nth-last-child(2)');
        if (lastChild) {
            lastChild.remove();
        }
    });

    schedule.addEventListener('change', function (event) {
        if (event.target.matches('[name^="param[dates]"]')) {
            const check_date = event.target;
            const parent = check_date.closest('.wowp-fields-group');
            const date_start = parent.querySelector('.wowp-field:nth-last-child(2)');
            const date_end = parent.querySelector('.wowp-field:nth-last-child(1)');
            if (check_date.checked) {
                date_start.classList.remove('is-hidden');
                date_end.classList.remove('is-hidden');
            } else {
                date_start.classList.add('is-hidden');
                date_end.classList.add('is-hidden');
            }


        }
    });

}

const feature = function () {
    const texts = document.querySelectorAll('.w_card-description');

    if (!texts) {
        return false;
    }
    texts.forEach((el) => {
        el.addEventListener('click', () => {
            el.classList.toggle('is-open');
        })
    })

}

document.addEventListener('DOMContentLoaded', function () {

    new codeEditor;
    new cloneIncludes;
    new removeLast;
    new settingTabs;
    new changeIncludes;

    new cloneDisplayRules;
    new removeDisplayRules;
    new changeDisplayRules;

    new userRoles;
    new languages;

    new schedule;

    new feature;
})