import { Theme } from 'theme-model.js';
var theme = new Theme(); //实例化  主题列表对象
Page({
    data: {
        loadingHidden: false
    },
    onReady:function(){
        wx.setNavigationBarTitle({
            title: this.data.titleName
        });
    },
    onLoad: function (option) {
        this.data.titleName=option.name;
        this.data.id=option.id;
        wx.setNavigationBarTitle({
            title: option.name
        });
        this._loadData();

    },

    /*加载所有数据*/
    _loadData:function(callback){
        var that = this;
        /*获取单品列表信息*/
        theme.getProductorData(this.data.id,(data) => {
            that.setData({
                themeInfo: data,
                loadingHidden:true
            });
            callback && callback();
        });
    },

    /*跳转到商品详情*/
    onProductsItemTap: function (event) {
        var id = theme.getDataSet(event, 'id');
        wx.navigateTo({
            url: '../product/product?id=' + id
        })
    },

    /*下拉刷新页面*/
    onPullDownRefresh: function(){
        this._loadData(()=>{
            wx.stopPullDownRefresh()
        });
    },

    //分享效果
    onShareAppMessage: function () {
        return {
            title: '凯尔亮商贸 Pretty Vendor',
            path: 'pages/theme/theme?id=' + this.data.id
        }
    }

})


