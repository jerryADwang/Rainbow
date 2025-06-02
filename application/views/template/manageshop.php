<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Manage shop</h1>
        <p class="lead text-muted">Have your owen shop here, by entering your user name and password
            If you have not yet created your shop, you can apply now. (Only for Premium user)</p>
        <p>
          <a href="#myshop" class="btn btn-primary my-2">Manage my shop</a>
          <a href="<?php echo base_url().'manage/createshop';?>" class="btn btn-secondary my-2">Apply a shop</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <h2 class="p2-3" id="myshop">My shops</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php if(!empty($result)) {
              echo $result;
            }
          ?>
        </div>
        <?php if(empty($result)) {
              echo $empty;
            }
        ?>
      <?php if($this->shop_model->ownerlist($this->session->userdata('username')) != Null) : ?>
        <?php echo form_open('Manage', array('method'=>'get'))?>
          <div class="row pt-5">
            <div class="col-5 form-inline">
                <div class="form-group">
                    <label for="score_sort"> Sorted with all shops:&nbsp;</label>
                    <select name="sort_by_type" id="score_sort" class="form-control" style="text-transform:capitalize;">
                      <option <?php if(isset($_GET['sort_by_type']) && $_GET['sort_by_type'] == "Comment" ) {echo "selected";} ?> value="Comment">Comment</option>
                      <option <?php if(isset($_GET['sort_by_type']) && $_GET['sort_by_type'] == "Wishlist" ) {echo "selected";} ?> value="Wishlist">Wishlist</option>
                      <option <?php if(isset($_GET['sort_by_type']) && $_GET['sort_by_type'] == "Thumpsup_num" ) {echo "selected";} ?> value="Thumpsup_num">Thumpsup_num</option>
                    </select>
                </div>
            </div>
            <div class="col-3 form-inline">
                <label for="participant_filter">Year&nbsp: &nbsp</label>
                <input size="10" id="participant_filter" type="text" class="form-control" name="year" value="<?php echo $year ?>">
            </div>
            <div class="col-1">
                <button type="submit" class="btn btn-primary" >Search</button>
            </div>
          </div>
        <!-- </form> -->
        <?php if(isset($dashboard_type)) 
          echo'<div id="bar" class="pt-3" style="width: 60rem;height:40rem;"></div>'
        ?>
        <!-- <?php echo form_open('Manage', array('method'=>'get'))?> -->
          <div class="row pt-3">
            <div class="col-4 form-inline">
                  <div class="form-group">
                      <label for="score_sort"> Sorted with single shop:&nbsp;</label>
                      <select name="sort_by" id="score_sort" class="form-control" style="text-transform:capitalize;">
                        <?php  
                          foreach($this->shop_model->ownerlist($this->session->userdata('username')) as $row) :?>
                            <option <?php if(isset($_GET['sort_by']) && $_GET['sort_by'] == $row->name ) {echo "selected";} ?> value="<?php echo $row->name ?>"><?php echo $row->name ?></option>
                        <?php endforeach; ?>		
                      </select>
                  </div>
              </div>
              <!-- <div class="col-1">
                  <button type="submit"  class="btn btn-primary" >Search</button>
              </div> -->
          </div>
        </form>
        <?php if(isset($dashboard)) 
          echo'<div id="line_chart" class="pt-3" style="width: 60rem;height:40rem;"></div>
              <div id="main" class="pt-5" style="width: 60rem;height:40rem;"></div>'
        ?>
      <?php endif; ?>
    </div>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.3.2/dist/echarts.js"></script>
<script>
  var myChart = echarts.init(document.getElementById('main'));
  option = {
    title: {
    text: 'Referer of The Total Number of Thumbsup and Wishlist in ' + '<?php echo $dashboard[0]->name?>',
    subtext: 'Whole years',
    left: 'center'
  },
  dataset: [
    {
      source: [
        ['Product', 'Sales', 'precentage'],
        ['Added to wishlist: ' + <?php echo $dashboard[0]->wishlist_num ?>, <?php echo $dashboard[0]->wishlist_num ?>,'wishlist'],
        ['Total users: '+ <?php echo $dashboard[0]->general_num ?>, + <?php echo $dashboard[0]->general_num ?>,  'wishlist'],
        ['Thumbsup: ' + <?php echo $dashboard[0]->thumpsup_num ?>, <?php echo $dashboard[0]->thumpsup_num ?>,  'thumbsup'],
        ['Total users: ' + <?php echo $dashboard[0]->thumps_down_num ?> , + <?php echo $dashboard[0]->thumps_down_num ?>, 'thumbsup'],
      ]
    },
    {
      transform: {
        type: 'filter',
        config: { dimension: 'precentage', value: 'wishlist' }
      }
    },
    {
      transform: {
        type: 'filter',
        config: { dimension: 'precentage', value: 'thumbsup' }
      }
    },
  ],
  series: [
    {
      type: 'pie',
      radius: 50,
      center: ['50%', '25%'],
      datasetIndex: 1
    },
    {
      type: 'pie',
      radius: 50,
      center: ['50%', '50%'],
      datasetIndex: 2
    },
  ],
  // Optional. Only for responsive layout:
  media: [
    {
      query: { minAspectRatio: 1 },
      option: {
        series: [
          { center: ['35%', '25%'] },
          { center: ['70%', '25%'] },
        ]
      }
    },
    {
      option: {
        series: [
          { center: ['50%', '25%'] },
          { center: ['50%', '50%'] },
        ]
      }
    }
  ]
};
option && myChart.setOption(option);

var chartDom = document.getElementById('line_chart');
var myChart = echarts.init(chartDom);
var line_chart;

line_chart = {
  title: {
    text: 'Year Comparison - '+'<?php echo $dashboard[0]->name?>'
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {},
  toolbox: {
    show: true,
    feature: {
      dataZoom: {
        yAxisIndex: 'none'
      },
      dataView: { readOnly: false },
      magicType: { type: ['line', 'bar'] },
      restore: {},
      saveAsImage: {}
    }
  },
  xAxis: {
    type: 'category',
    boundaryGap: false,
    data: ['2019', '2020', '2021', '2022']
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      formatter: '# {value}'
    }
  },
  series: [
    {
      name: 'Wishlist number',
      type: 'line',
      data: [<?php echo $dashboard[0]->wishlist_num_2019 ?>, <?php echo $dashboard[0]->wishlist_num_2020 ?>, <?php echo $dashboard[0]->wishlist_num_2021 ?>, <?php echo $dashboard[0]->wishlist_num_2022 ?>],
      markLine: {
        data: [{ type: 'average', name: 'Avg' }]
      }
    },
    {
      name: 'Thumbsup number',
      type: 'line',
      data: [<?php echo $dashboard[0]->thumpsup_num_2019 ?>, <?php echo $dashboard[0]->thumpsup_num_2020 ?>,<?php echo $dashboard[0]->thumpsup_num_2021 ?>, <?php echo $dashboard[0]->thumpsup_num_2022 ?>],
      markLine: {
        data: [{ type: 'average', name: 'Avg' }]
      }
    }
  ]
};

line_chart && myChart.setOption(line_chart);





var chartDom = document.getElementById('bar');
var myChart = echarts.init(chartDom);
var bar;

bar = {
  title: {
    text: 'All Shops Comparison - '+'<?php echo $sort_by_type ?>' + ' ' + '<?php echo $year ?>'
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {},
  toolbox: {
    show: true,
    feature: {
      dataZoom: {
        yAxisIndex: 'none'
      },
      dataView: { readOnly: false },
      magicType: { type: ['line', 'bar'] },
      restore: {},
      saveAsImage: {}
    }
  },
  xAxis: {
    type: 'category',
    data: [<?php 
              foreach($this->shop_model->ownerlist($this->session->userdata('username')) as $row) {
                echo "'$row->name',";
              }
            ?>]
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      formatter: '# {value}'
    }
  },
  series: [
    {
      data: [<?php 
                foreach($this->shop_model->ownerlist($this->session->userdata('username')) as $row) {
                  $shopname = $row->name;
                  $data = $dashboard_type[0]->$shopname;
                  echo "$data,";
                }
              ?>],
      type: 'bar'
    }
  ]
};

bar && myChart.setOption(bar);
</script>
