var myChart = echarts.init(document.getElementById('main'),'shine'),
app = {};
var option = {
    title: {
        text: '动态数据',
        subtext: '纯属虚构',
        x:'center'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross',
            label: {
                backgroundColor: '#283b56'
            }
        }
    },
    legend: {
        data:[ '预购队列','预购队列1'],
        x:'left'
    },
    toolbox: {
        show: true,
        feature: {
            dataView: {readOnly: false},
            restore: {},
            saveAsImage: {}
        }
    },
    dataZoom: {
        show: false,
        start: 0,
        end: 100
    },
    xAxis: {
        type: 'category',
        boundaryGap: true,
        data: (function (){
            var res = [];
            var len = 10;
            while (len--) {
                res.push(len + 1);
            }
            return res;
        })()
    },
    yAxis:{
        type: 'value',
        scale: true,
        name: '',
        max: 30,
        min: 0,
        boundaryGap: [0.2, 0.2]
    },
    series: [
        {
            name:'预购队列',
            type:'bar',
            // xAxisIndex: 1,
            // yAxisIndex: 1,
            data:(function (){
                var res = [];
                var len = 10;
                while (len--) {
                    res.push(Math.round(Math.random() * 30));
                }
                return res;
            })()
        },
        {
            name:'预购队列1',
            type:'bar',
            // xAxisIndex: 1,
            // yAxisIndex: 1,
            data:(function (){
                var res = [];
                var len = 10;
                while (len--) {
                    res.push(Math.round(Math.random() * 30));
                }
                return res;
            })() 
        }
    ],
    color:['#abcde','#adefff','#abfcc','pink','green']
};
myChart.setOption(option);
// 柱状图结束

// 折线图
var left = echarts.init(document.getElementById('left'),'shine');

var option1 = {
    title:{
        text:'折线图',
        x:'center'
    },
    tooltip:{},
    legend:{
        data:['test','test1'],
        x:"left"
    },
    xAxis:{
        data:['1','2','3','4','5','6']
    },
    yAxis:{},
    series:[{
        name:'test',
        type:'line',
        data:[5,20,6,7,50,3]
    },
    {
        name:"test1",
        type:'line',
        data:[7,10,25,30,20,10]
    }],
    color:['pink','green','#ace','#cde','#fac']
};
left.setOption(option1);
