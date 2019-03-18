import { Category } from 'category-model.js';
var category=new Category();  //实例化 home 的推荐页面
Page({
  data: {
    transClassArr:['tanslate0','tanslate1','tanslate2','tanslate3','tanslate4','tanslate5'],
    currentMenuIndex:0,
    loadingHidden:false,
  },
  onLoad: function () {
    this._loadData();
  },

  /*加载所有数据*/
  _loadData:function(callback){
    var that = this;
    category.getCategoryType((categoryData)=>{

      that.setData({
        categoryTypeArr: categoryData,
        loadingHidden: true
      });
      // 一定在回调里进行获取分类详情的方法调用
      that.getProductsByCategory(categoryData[0].id,(data)=>{
        var dataObj= {
          procucts: data,
          topImgUrl: categoryData[0].img.url,
          title: categoryData[0].name
        };
        that.setData({
          loadingHidden: true,
          categoryInfo0:dataObj,
        });
        callback&& callback();
      });
    });
  },

  /*切换分类*/
  changeCategory:function(event){
    var index=category.getDataSet(event,'index'),
        id=category.getDataSet(event,'id')//获取data-set
    this.setData({
      currentMenuIndex:index
    });

    //如果数据是第一次请求
    if(!this.isLoadedData(index)) {
      var that=this;
      this.getProductsByCategory(id, (data)=> {
        that.setData(that.getDataObjForBind(index,data));
      });
    }
  },

  isLoadedData:function(index){
    if(this.data['categoryInfo'+index]){
      return true;
    }
    return false;
  },

  getDataObjForBind:function(index,data){
    var obj={},
        arr=[0,1,2,3,4,5],
        baseData=this.data.categoryTypeArr[index];
    for(var item in arr){
      if(item==arr[index]) {
        obj['categoryInfo' + item]={
          procucts:data,
          topImgUrl:baseData.img.url,
          title:baseData.name
        };

        return obj;
      }
    }
  },

  getProductsByCategory:function(id,callback){
    category.getProductsByCategory(id,(data)=> {
      callback&&callback(data);
    });
  },

  /*跳转到商品详情*/
  onProductsItemTap: function (event) {
    var id = category.getDataSet(event, 'id');
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
      title: '凯尔亮 trade and business',
      path: 'pages/category/category'
    }
  }

})