// ********
// Don't forget to remove the distance between the bottom of the container and the bottom if it is less than viewport height
// ********

// Let's create an extendable object for each container (you'll be able to stack them in a russian doll as well)
var Block = function (container) {
  var i;
  this.container = container;
  this.config = etc_dc_config[container.attr('id')];

  // Let's put an override in here temporarily to measure the size of the nav bar in case the height is set
  // to something else besides 37
  this.config.ploffset = jQuery('#navbar').outerHeight() + jQuery('#wpadminbar').outerHeight();

  if( this.config.fullheight == '1' ) {
    container.css('height', jQuery(window).height()-this.config.ploffset);
  }

  // Let's set some stats statically
  this.h = container.outerHeight();
  this.w = container.outerWidth();
  this.ot = container.offset().top;
  this.ob = doc.h - this.ot - this.h;

  // Let's churn our perfect world
  this.target = churnTargetDimensions(this);

  // Let's create backdrop objects for every background
  var backgrounds = container.css('background-image').replace(/url\((['"])?(.*?)\1\)/gi, '$2').split(',');
  if(backgrounds.length>0) {
    this.backdrops = [];
    for ( i = 0; i < backgrounds.length; i++ ) {
      this.backdrops[i] = new Backdrop(backgrounds[i]);
    }
  }

  // Let's attach the scroll speed for each backdrop if they are set
  if(this.config.bg_ratio_v){
    for ( i = 0; i < this.config.bg_ratio_v.length; i++ ){
      this.backdrops[i].vratio = this.config.bg_ratio_v[i];
    }
  }

  if(this.config.bg_ratio_h){
    for ( i = 0; i < this.config.bg_ratio_h.length; i++ ){
      this.backdrops[i].hratio = this.config.bg_ratio_h[i];
    }
  }

  // Let's attach the centering configuration for each backdrop
  if(this.config.bg_centered){
    for ( i = 0; i < this.config.bg_centered.length; i++ ){
      this.backdrops[i].centered = this.config.bg_centered[i];
    }
  }

  // Let's create sprite objects for every sprite
  this.sprites = [];
  var s;
  for ( i = 0; i < jQuery('.depthChargeSprite').size(); i++ ){
    this.sprites.push(new Sprite(jQuery('.depthChargeSprite').eq(i)));
    s = this.sprites[i];
    s.vratio = Number(this.config.sp_ratio_v[i]);
    // get the offsets here
  }

  // Let's churn our sizing to get to our perfect world
  churnAttributes(this);

  // Let's output the attributes
  applyAttributes(this);
};

var Backdrop = function (imageSrc) {
  var image = new Image();
  image.src = imageSrc;

  this.h = image.height;
  this.w = image.width;
};

var Pane = function (container) {
  this.container = container;
};

var Sprite = function (element) {
  this.element = element;
  this.h = element.outerHeight();
  this.w = element.outerWidth();
};

Block.prototype.getContainer = function () {
  return this.container;
};

//var bottom = jQuery(document).height() - offset - cheight;

function churnSmartPosition(t,p){
  // t is the sprite object
  // p is the parent (block)
  var output = [];
  // o is wrong, have to attach it to the proper configuration options (vh offset)
  output.top = (p.h/2)-(t.h/2)+p.config.ploffset;
  output.left = (p.w/2)-(t.w/2);
  return output;
}

function churnPaths(t,p){
  // t is the sprite object
  // p is the parent (block)

  var path = [];
  path[0] = [];

  path[0]['w'] = t.smartposition.left;
  path[0]['h'] = t.smartposition.top;

  // Let's figure out the distance it should travel
  var d = [];
  d.w = 0;
  d.h = (t.vratio+1)*2000;

  // Let's get the other waypoint
  path[2000] = [];
  path[2000]['w'] = t.smartposition.left+d.w;
  path[2000]['h'] = t.smartposition.top+d.h;

  return path;
}

function churnTargetDimensions(t){
  // t = block

  // Let's calculate the bottom "pull" to see if the offset from bottom is smaller than the viewport
  var bPull = 0;
  if(t.ob<win.h){
    bPull = win.h - t.ob - t.h;
  }

  var output = [];
  // Let's calculate the appropriate height
  if(t.ot>=win.h){
    output.h = (win.h - bPull);
  }
  else{
    output.h = (t.h + t.ot - bPull);
  }

  // Let's calculate the appropriate width
  output.w = t.w;
  return output;
}

function churnSize(t,p){
  // t = backdrop
  // p = parent (block)
  //console.log(p.ot);
  var wRatio, wSpread, hRatio, hSpread, oHeight, oWidth;

  // Let's put some checks and balances on this
  // The calculated height can't be less than the height itself of the block
  // !!!!!!!!!!!!Need to account for offset of mobile menu!
  if ((p.target.h*Math.abs(t.vratio)) < (p.h) ) {
    oHeight = (p.h);
  } else {
    oHeight = (p.target.h*Math.abs(t.vratio));
  }

  wRatio = t.w/p.target.w;
  wSpread = wRatio-1;
  hRatio = t.h/oHeight;
  hSpread = hRatio-1;

  var multiplier;
  var setDimension;

  //console.log('wRatio: ' + wRatio);
  //console.log('wSpread: ' + wSpread);
  //console.log('hRatio: ' + hRatio);
  //console.log('hSpread: ' + hSpread);

  // Are either of the dimensions lacking?
  if(hRatio<1 || wRatio<1){
    // If height has a larger spread than width, let's multiply it up properly
    if(hSpread<=wSpread){
      // Let's figure out how much we have the multiply the dimension
      multiplier = 1/hRatio;
      setDimension = multiplier*t.h;
      //console.log(1);
      return { w:'auto', h:setDimension };
    }
    if(hSpread>wSpread){
      // Let's figure out how much we have the multiply the dimension
      multiplier = 1/wRatio;
      setDimension = multiplier*t.w;
      //console.log(2);
      return { w:setDimension, h:'auto' };
    }
  }

  if(hRatio>=1 && wRatio>=1){
    if(hSpread<=wSpread){
      multiplier = 1/hRatio;
      setDimension = multiplier*t.h;
      //console.log(3);
      return { w:'auto', h:setDimension };
    }
    if(hSpread>wSpread){
      multiplier = 1/wRatio;
      setDimension = multiplier*t.w;
      //console.log(4);
      return { w:setDimension, h:'auto' };
    }
  }

  if(hRatio==1 && wRatio==1){
    return null;
  }
}

function churnAttributes(t){
  var i, k;
  if(t.backdrops){
    for ( i = 0; i < t.backdrops.length; i++ ) {
      k = t.backdrops[i];
      t.backdrops[i].smartsize = churnSize(k,t);
      t.backdrops[i].waypoints = churnWaypoints(k,t);
    }

    for ( i = 0; i < t.config.bg_smartsize.length; i++ ) {
      t.backdrops[i].smartsize['status'] = t.config.bg_smartsize[i];
    }
  }
  if(t.sprites){
    for ( i = 0; i < t.sprites.length; i++ ) {
      k = t.sprites[i];
      k.smartposition = churnSmartPosition(k,t);
      k.path = churnPaths(k,t);
    }
  }
}

function getDataAttributeNames(elem) {
    var names = [],
        rDataAttr = /^data-/;
    jQuery.each(elem.attributes, function(i, attr) {
        if (attr.specified && rDataAttr.test(attr.name)) {
            names.push(attr.name);
        }
    });
    return names;
}

function getDataAttributes(node) {
    var d = {};
    var re_dataAttr = /^data\-(.+)$/;

    jQuery.each(node.get(0).attributes, function(index, attr) {
        if (re_dataAttr.test(attr.nodeName)) {
            var key = attr.nodeName.match(re_dataAttr)[1];
            d[key] = attr.nodeValue;
        }
    });

    return d;
}

function applyAttributes(t){
  // t should be a block or parent entity
  var i,j,k;
  var key;
  var attributes = [];

  existingData = getDataAttributes(t.container);
  for ( key in existingData ) {
    if ( existingData.hasOwnProperty(key) ) {
      t.container.removeAttr('data-' + key );
    }
  }

  if(t.backdrops){
    var attrSizes = [];
    for ( i = 0; i < t.backdrops.length; i++ ) {
      k = t.backdrops[i];
      for ( j = 0; j < k.waypoints.length; j++ ) {
        // We only need to set he variable the first time ** note: there has to be a better way to do this. Too tired.
        if(!attributes[k.waypoints[j]['index']]){
          attributes[k.waypoints[j]['index']] = [];
        }
        // Let's merge all the attributes into an index array based on waypoint location
        // We need to implode the array as a string
        attributes[k.waypoints[j]['index']].push([pixelize(k.waypoints[j].w),pixelize(k.waypoints[j].h)].join(' '));
      }

      if ( k.smartsize.status == 1) {
        attrSizes.push(pixelize(k.smartsize.w) + ' ' + pixelize(k.smartsize.h));
      } else {
        attrSizes.push('auto auto');
      }
    }

    for ( key in attributes ) {
      if ( attributes.hasOwnProperty(key) ) {
        t.container.attr('data-'+key,'background-position: ' + attributes[key].join(',') + ';');
      }
    }

  }

  if(t.sprites){
    for ( i = 0; i < t.sprites.length; i++ ) {
      k = t.sprites[i];
      for ( key in k.path ) {
        if ( k.path.hasOwnProperty(key) ) {
          k.element.attr('data-' + key,'top: ' + k.path[key].h + 'px; left: ' + k.path[key].w + 'px;');
        }
      }
    }
  }
}

function pixelize(k){
  if( !isNaN(k) ){
    k = k + "px";
  }
  return k;
}

function churnWaypoints(t,p){
  // t = the object passed that we are currently analyzing
  // p = parent container, most likely the block
  var waypoints = [];
  waypoints[0] = [];
  waypoints[1] = [];

  // Will need to rewrite this to allow for unlimited potential waypoints and horizontals, right now hardwire for 2 verticals
  if(p.ot>win.h){
    waypoints[0]['index'] = 'bottom-top';
    waypoints[1]['index'] = 'bottom-' + Math.round(p.target.h);
  } else {
    waypoints[0]['index'] = 0;
    waypoints[1]['index'] = Math.round(p.ot + p.h);
  }

  // These waypoints are strictly based on vertical positioning for the time being
  // Need to update these to accept horizontals with next version

  // Let's check to see if we're supposed to be centering the image
  var hpoint = 0;
  t.centered == '1' && (hpoint = '50%');

  // What direction is the parallax supposed to be moving?
  if(t.vratio < 0){
    waypoints[0]['w'] = hpoint;
    waypoints[0]['h'] = 0+p.config.ploffset;
    waypoints[1]['w'] = hpoint;
    waypoints[1]['h'] = (p.target.h * t.vratio)+p.config.ploffset;
  } else {
    waypoints[0]['w'] = hpoint;
    //waypoints[0]['h'] = p.h-(p.h * t.vratio)+p.config.ploffset;
    waypoints[0]['h'] = (p.h)-(p.target.h * t.vratio)+p.config.ploffset;
    //if(Math.abs(waypoints[0]['h']) < p.h){
    //  console.log('is less than ' + p.h);
    //  waypoints[0]['h'] = p.ot-p.h+p.config.ploffset;
    //}
    waypoints[1]['w'] = hpoint;
    waypoints[1]['h'] = 0;
  }

  return waypoints;
}

function engageDepthCharge(s){
  win = [];
  doc = [];
  // Let's set some static stats about our playground
  win.w = jQuery(window).width();
  win.h = jQuery(window).height();
  doc.w = jQuery(document).width();
  doc.h = jQuery(document).height();

  jQuery.fn.hasAttrMatching = function (expr) {
      var reg, data;
      if (!expr) {
          return this;
      } else {
          if (typeof expr === 'string') {
              reg = new RegExp(expr);
          } else if (typeof expr === 'object' && expr.test) {
              reg = expr;
          }
          return this.filter(function () {
              data = $(this).data();
              for (var a in data) {
                  if (data.hasOwnProperty(a)) {
                      return reg.test(a);
                  }
              }
          });
      }
  };

  jQuery('.depthChargeBlock').each(function(){
    var block = new Block(jQuery(this));
  });

}

window.onload = function(){
  engageDepthCharge();
  /**
  var s = skrollr.init({
    forceHeight: false,
    smoothScroll: true
  });
  */
  if(!(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)){
    var s = skrollr.init({
        forceHeight: true,
        smoothScroll: true
    });
  }
};

window.onresize = function(){
  engageDepthCharge();
  skrollr.get().refresh();
};