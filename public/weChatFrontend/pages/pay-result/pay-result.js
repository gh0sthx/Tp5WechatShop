
Page({
        data: {

        },
        onLoad: function (options){
            this.setData({
                payResult:options.flag,
                id:options.id,
                from:options.from
            });
        },
        viewOrder:function(){
            if(this.data.from=='my'){
                wx.redirectTo({
                    url: '../order/order?from=order&id=' + this.data.id
                });
            }else{
                //返回上一级
                wx.navigateBack({
                    delta: 1
                })
            }
        }
    }
)