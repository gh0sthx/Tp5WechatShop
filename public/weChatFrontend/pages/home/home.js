import {
  Home
} from 'home-model.js';
var home = new Home(); //实例化 首页 对象
var WxSearch = require('../../wxSearch/wxSearch.js')
Page({
  data: {
    loadingHidden: false
  },
  onLoad: function() {
    this._loadData();
  },

  /*加载所有数据*/
  _loadData: function(callback) {
    var that = this;
    // 搜索框加载
    WxSearch.init(that, 43, ['weappdev', '小程序', 'wxParse', 'wxSearch', 'wxNotification']);
    WxSearch.initMindKeys(['weappdev.com', '微信小程序开发', '微信开发', '微信小程序']);
    // 获得bannar信息
    home.getBannerData((data) => {
      that.setData({
        bannerArr: data,
      });
    });

    /*获取主题信息*/
    home.getThemeData((data) => {
      that.setData({
        themeArr: data,
        loadingHidden: true
      });
    });

    /*获取单品信息*/
    home.getProductorData((data) => {
      that.setData({
        productsArr: data
      });
      callback && callback();
    });
  },

  /*跳转到商品详情*/
  onProductsItemTap: function(event) {
    var id = home.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id
    })
  },

  /*跳转到主题列表*/
  onThemesItemTap: function(event) {
    var id = home.getDataSet(event, 'id');
    var name = home.getDataSet(event, 'name');
    wx.navigateTo({
      url: '../theme/theme?id=' + id + '&name=' + name
    })
  },

  /*下拉刷新页面*/
  onPullDownRefresh: function() {
    this._loadData(() => {
      wx.stopPullDownRefresh()
    });
  },

  //分享效果
  onShareAppMessage: function() {
    return {
      title: '凯尔亮商贸 Pretty Vendor',
      path: 'pages/home/home'
    }
  }

})