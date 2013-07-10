// ********
// DepthCharge Custom JS Engine
// Copyright etc.io
// Version: 1.0c
// All Rights Reserved
// ********

// Let's create an extendable object for each container (you'll be able to stack them in a russian doll as well)

var win,doc;
var Block = function (container) {
  var i;
  this.container = container;
  this.config = etc_dc_config[container.attr('id')];
  this.plid = container.attr('id');

  // Let's put an override in here temporarily to measure the size of the nav bar in case the height is set
  // to something else besides 37
  this.config.ploffset = jQuery('#navbar').outerHeight() + jQuery('#wpadminbar').outerHeight();

  if( this.config.pl == 1 ) {
    this.config.ploffset = this.config.ploffset + 57;
  }

  if( this.config.fullheight == '1' ) {
    container.css('height', jQuery(window).height()-this.config.ploffset);
  }

  // Let's set some stats statically
  this.h = container.outerHeight();
  this.w = container.outerWidth();
  this.ot = Math.round(container.offset().top);
  this.ob = Math.round(jQuery('body').height() - this.ot - this.h);

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
      this.backdrops[i].vratio = +this.config.bg_ratio_v[i];
    }
  }

  if(this.config.bg_ratio_h){
    for ( i = 0; i < this.config.bg_ratio_h.length; i++ ){
      this.backdrops[i].hratio = +this.config.bg_ratio_h[i];
    }
  }

  // Let's attach the centering configuration for each backdrop
  if(this.config.bg_centered){
    for ( i = 0; i < this.config.bg_centered.length; i++ ){
      this.backdrops[i].centered = +this.config.bg_centered[i];
    }
  }

  // Let's create sprite objects for every sprite
  this.sprites = [];
  var s;
  for ( i = 0; i < jQuery('#' + this.plid + ' .depthChargeSprite').size(); i++ ){
    this.sprites.push(new Sprite(jQuery('#' + this.plid + ' .depthChargeSprite').eq(i)));
    s = this.sprites[i];
    s.vratio = +this.config.sp_ratio_v[i];
    s.voffset = +this.config.sp_offset_v[i];
    s.hoffset = +this.config.sp_offset_h[i];
    s.slingshot = this.config.sp_slingshot[i];
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

//var bottom = jQuery(document).height() - offset - cheight;

function churnSmartPosition(t,p){
  // t is the sprite object
  // p is the parent (block)
  var output = [];
  output.top = (p.h/2)-(t.h/2)+t.voffset;
  output.left = (p.w/2)-(t.w/2)+t.hoffset;
  return output;
}

function churnPaths(t,p){
  // t is the sprite object
  // p is the parent (block)

  var path = [];
  var d = [];
  // not doing right and left animations right now
  d.w = 0;
  // multiplier of the distance
  d.m = t.vratio + 1;

  path[0] = [];

  // Let's go ahead and set the first waypoints
  // d.h = distance the item will need to travel (includes ratio)
  // d.r = "raw" distance (without ratio)
  // d.w = distance will need to travel sideways (not currently used)
  if(t.slingshot){
    // Let's set the variable for the distance it will travel to mid point to reapply it below

    // distance for the first half to travel
    d.th = Math.round(p.h/2 + p.ot - win.h/2);
    path[0]['h'] = t.smartposition.top - d.th * d.m;
    path[0]['w'] = t.smartposition.left;

    // Let's set the midpoint
    path[d.th] = [];
    path[d.th]['h'] = t.smartposition.top;
    path[d.th]['w'] = t.smartposition.left;

    // only need this if the item is net "down"
    if(t.vratio > 0){
      // distance for the second half to travel
      d.bh = p.ob + p.h - t.smartposition.top - t.h;
      // raw distance for waypoint
      d.rbh = Math.round(d.bh/d.m);

      path[d.th + d.rbh] = [];
      path[d.th + d.rbh]['h'] = path[d.th]['h'] + d.bh;
      path[d.th + d.rbh]['w'] = t.smartposition.left;
    } else {
      // second half is "infinite" since it goes up and doesn't matter
      // let's create a "buffer" to factor against - 100000px should be more than enough
      d.buff = 100000;
      path[d.th + d.buff] = [];
      path[d.th + d.buff]['h'] = path[d.th]['h'] + d.buff * d.m;
      path[d.th + d.buff]['w'] = t.smartposition.left;
    }
  } else {
    path[0]['h'] = t.smartposition.top;
    path[0]['w'] = t.smartposition.left;

    // only need this if the item is net "down"
    if(t.vratio > 1){
      // distance for the second half to travel
      d.bh = p.ob + p.h - t.smartposition.top - t.h;
      d.rbh = Math.round(d.bh/d.m);

      path[d.rbh] = [];
      path[d.rbh]['h'] = d.bh;
      path[d.rbh]['w'] = t.smartposition.left;
    } else {
      // second half is "infinite" since it goes up and doesn't matter
      // let's create a "buffer" to factor against - 100000px should be more than enough
      d.buff = 100000;
      path[d.buff] = [];
      path[d.buff]['h'] = d.buff * d.m;
      path[d.buff]['w'] = t.smartposition.left;
    }
  }

  // We need to make sure the sprites don't go off the bottom and extend the footer if constrain is off
  //if( !p.config.contained ){
    //if( (d.h+(t.h/2)) > (p.ob + t.h - t.smartposition.top)){
  //  d.h = p.ob + p.h - t.smartposition.top - (t.h);
  //  d.r = d.h/(t.vratio+1);
    //}
  //}

  return path;
}

function churnTargetDimensions(t){
  // t = block

  // Let's calculate the bottom "pull" to see if the offset from bottom is smaller than the viewport
  var bPull = 0;
  // ****** HAVE TO FIX THE BOTTOM PULL
  //if(t.ob<win.h){
  //  bPull = win.h - t.ob - t.h;
  //}

  var output = [];
  // Let's calculate the appropriate height
  if(t.ot>=win.h){
    output.h = (win.h + t.h - bPull);
  }
  else{
    output.h = (t.h + t.ot - bPull);
    //console.log(t.ot);
    //console.log(bPull);
    //console.log(output.h);
  }

  // Let's calculate the appropriate width
  output.w = t.w;
  return output;
}

function churnSize(t,p){
  // t = backdrop
  // p = parent (block)
  var wRatio, wSpread, hRatio, hSpread, oHeight, oWidth, aRatio;

  // Let's put some checks and balances on this
  // The calculated height can't be less than the height itself of the block

  /*
  if ( t.vratio > -1 && t.vratio < 0 ){
    //console.log(t.vratio);
    aRatio = 1 + ( 1 - Math.abs(t.vratio) );
    //console.log(aRatio);
  } else {
    aRatio = Math.abs(t.vratio);
  }
  console.log(t.vratio);
  console.log(aRatio);
  */

  aRatio = Math.abs(t.vratio);

  //console.log(t.vratio);

  if ( t.vratio >= 0 ) {
    // Reverse
    //console.log(233);
    //console.log('The target is: ' + p.target.h);
    oHeight = p.target.h + (p.target.h*aRatio);
    //console.log(oHeight);
    if( ( p.ot + p.config.ploffset ) >= win.h ){
      console.log(oHeight);
      oHeight = oHeight;
    }
    if ( oHeight < (p.h*aRatio)) {
      oHeight = p.h*aRatio;
    }
  } else {
    // Forward
    //console.log(264);
    oHeight = (p.target.h*aRatio);
    //console.log('266: ' + oHeight);
    if(p.ot >= win.h){
      oHeight = 2*p.h*aRatio;
      //console.log('269: ' + oHeight);
      if ( oHeight < (p.h+(p.h*aRatio))){
        oHeight = (p.ot + p.h)*aRatio;
        //console.log('272: ' + oHeight);
      }
    }
    //console.log('275: ' + oHeight);
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
      return { w:'auto', h:Math.round(setDimension), oHeight: oHeight };
    }
    if(hSpread>wSpread){
      // Let's figure out how much we have the multiply the dimension
      multiplier = 1/wRatio;
      setDimension = multiplier*t.w;
      //console.log(2);
      return { w:Math.round(setDimension), h:'auto', oHeight: oHeight };
    }
  }

  if(hRatio>=1 && wRatio>=1){
    if(hSpread<=wSpread){
      multiplier = 1/hRatio;
      setDimension = multiplier*t.h;
      //console.log(3);
      return { w:'auto', h:Math.round(setDimension), oHeight: oHeight };
    }
    if(hSpread>wSpread){
      multiplier = 1/wRatio;
      setDimension = multiplier*t.w;
      //console.log(4);
      return { w:Math.round(setDimension), h:'auto', oHeight: oHeight };
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

function pixelize(k){
  if( !isNaN(k) ){
    k = k + "px";
  }
  return k;
}

function applyAttributes(t){
  // t should be a block or parent entity
  var i,j,k;
  var key;
  var attributes = [];

  // Let's delete the current data tags that are attached (have to use js not jQuery because it doesn't update)
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

    // Let's add the background sizes
    t.container.css('background-size', attrSizes);

  }

  if(t.sprites){
    for ( i = 0; i < t.sprites.length; i++ ) {
      k = t.sprites[i];
      existingData = getDataAttributes(k.element);
      for ( key in existingData ) {
        if ( existingData.hasOwnProperty(key) ) {
          k.element.removeAttr('data-' + key );
        }
      }
      for ( key in k.path ) {
        if ( k.path.hasOwnProperty(key) ) {
          k.element.attr('data-' + key,'top: ' + k.path[key].h + 'px; left: ' + k.path[key].w + 'px;');
        }
      }
    }
  }
}

function churnWaypoints(t,p){
  // t = the object passed that we are currently analyzing
  // p = parent container, most likely the block
  var waypoints = [];
  waypoints[0] = [];
  waypoints[1] = [];

  // Will need to rewrite this to allow for unlimited potential waypoints and horizontals, right now hardwire for 2 verticals
  if( ( p.ot + p.config.ploffset ) > win.h ){
    waypoints[0]['index'] = 'bottom-top';
    waypoints[1]['index'] = -p.target.h + '-bottom-top';
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
  if(t.vratio <= 0){
    // Forward
    waypoints[0].w = hpoint;
    waypoints[0].h = 0;
    waypoints[1].w = hpoint;
    waypoints[1].h = -t.smartsize.oHeight + p.h;
    console.log(466);
    if( ( p.ot + p.config.ploffset ) >= win.h ){
      console.log(468);
      waypoints[0].h = waypoints[0].h;
      waypoints[1].h = waypoints[1].h;
    }
  } else {
    // Reverse
    waypoints[0].w = hpoint;
    waypoints[1].w = hpoint;
    waypoints[0].h = -(t.smartsize.oHeight-p.h);
    waypoints[1].h = -(0-p.h);
    console.log(478);
    if( (p.ot + p.config.ploffset) >= win.h ){
      console.log(480);
      waypoints[0].h = waypoints[0].h - p.h;
      waypoints[1].h = waypoints[1].h - p.h;
    }
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
  doc.h = jQuery('html').height();

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
    //console.log(block);
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
        forceHeight: false,
        smoothScroll: true
    });
  }
  if(jQuery('.depthChargeSprite .slabtext')[0]){
    jQuery(".depthChargeSprite h1").slabText({
        // Don't slabtext the headers if the viewport is under 380px
        "viewportBreakpoint":380
    });
  }
};

window.onresize = function(){
  engageDepthCharge();
  skrollr.get().refresh();
};