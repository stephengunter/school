window.$ = window.jQuery = require('jquery');
require('../css/app.css');
require('../css/font-awesome.css');
require('../css/site.css');
require('../summernote/summernote.css');

require('bootstrap-sass');

require('../summernote/summernote.js');
require('../summernote/lang/summernote-zh-TW.js');

import Vue from 'vue';
Vue.component('modal', require('vue-strap/src/modal') )
Vue.component('alert', require('vue-strap/src/alert') )
Vue.component('tooltip', require('vue-strap/src/tooltip') )


import vSelect from 'vue-select'
Vue.component('drop-down', vSelect)
Vue.component('date-picker', require('vue-datepicker') )
Vue.component('time-picker', require('vue2-timepicker') )
Vue.component('pager', require('vue-simple-pager') )

Vue.component('html-editor', require('./components/HtmlEditor') )
Vue.component('delete-confirm', require('./components/DeleteConfirm') )
Vue.component('toggle', require('./components/Toggle') )
Vue.component('checkbox', require('./components/CheckBox') )
Vue.component('data-viewer', require('./components/DataViewer') )
Vue.component('photo', require('./components/Photo') )
Vue.component('image-upload', require('./components/ImageUpload') )
Vue.component('role-label', require('./components/RoleLabel') )
Vue.component('combination-select', require('./components/CombinationSelect') )
Vue.component('updated', require('./components/Updated') )
Vue.component('user-card', require('./components/UserCard') )
Vue.component('tree-view', require('./components/TreeView') )
Vue.component('tree-item', require('./components/TreeItem') )
Vue.component('level-dropdown', require('./components/LevelDropdown') )
Vue.component('level-dropdown-item', require('./components/LevelDropdownItem') )


Vue.component('department-index', require('./views/department/index') )
Vue.component('department-details', require('./views/department/details') )





import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common = {   
    'X-Requested-With': 'XMLHttpRequest' 
};
import Moment from 'moment'
import MomentTimeZone from 'moment-timezone'
window.Moment = Moment;
window.MomentTimeZone = MomentTimeZone;

import Form from './utilities/Form';
import Helper from './helper.js'
import Config from './config.js'

import TimeService from './services/time.js'
import CommonService from './services/common.js'

import Auth from './packages/auth/Auth.js'
Vue.use(Auth)

window.Form = Form
window.Helper = Helper
window.Config = Config

window.TimeService = TimeService
window.CommonService = CommonService




import Department from './models/department.js'
import User from './models/user.js'

window.Department = Department
window.User = User




window.Vue = Vue

Vue.filter('strTime', function (datetime) {
    return Helper.tpeTime(datetime)
})
Vue.filter('tpeTime', function (datetime) {
    return Helper.tpeTime(datetime)
})
Vue.filter('boolText', function (val) {
      return Helper.boolText(val)
})
Vue.filter('genderText', function (gender) {
        if (parseInt(gender)) return '男'
        return '女'
})
Vue.filter('activeLabel', function (active) {
   return   Helper.activeLabel(active)
   
})
Vue.filter('reviewedLabel', function (reviewed) {
    return Helper.reviewedLabel(reviewed)
})
Vue.filter('statusLabel', function (status) {
    return Helper.reviewedLabel(reviewed)
})
Vue.filter('showIcon', function (icon) {
    if(!icon)  return ''
    return '<i class="' + icon + '"  aria-hidden="true"></i>'
})
Vue.filter('formatMoney', function (val) {
    return Helper.formatMoney(val)
})
Vue.filter('namesText', function (names) {
    return Helper.namesText(names)
})
Vue.filter('titleHtml', function (title) {
    return Helper.getTitleHtml(title)
})
Vue.filter('tryParseInt', function (val) {
    return Helper.tryParseInt(val)
})
Vue.filter('okSign', function (val) {
     return Helper.okSign(val)
})

window.Bus = new Vue({});









//window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

//window.$ = window.jQuery = require('jquery');

// Vue.http.interceptors.push((request, next) => {
//     request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

//     next();
// });