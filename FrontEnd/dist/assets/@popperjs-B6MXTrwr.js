var pr=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{};function ur(t){return t&&t.__esModule&&Object.prototype.hasOwnProperty.call(t,"default")?t.default:t}function xt(t){if(t.__esModule)return t;var e=t.default;if(typeof e=="function"){var r=function n(){return this instanceof n?Reflect.construct(e,arguments,this.constructor):e.apply(this,arguments)};r.prototype=e.prototype}else r={};return Object.defineProperty(r,"__esModule",{value:!0}),Object.keys(t).forEach(function(n){var o=Object.getOwnPropertyDescriptor(t,n);Object.defineProperty(r,n,o.get?o:{enumerable:!0,get:function(){return t[n]}})}),r}var D="top",R="bottom",S="right",$="left",me="auto",ee=[D,R,S,$],Y="start",J="end",Je="clippingParents",Pe="viewport",G="popper",Ke="reference",xe=ee.reduce(function(t,e){return t.concat([e+"-"+Y,e+"-"+J])},[]),je=[].concat(ee,[me]).reduce(function(t,e){return t.concat([e,e+"-"+Y,e+"-"+J])},[]),Qe="beforeRead",Ze="read",et="afterRead",tt="beforeMain",rt="main",nt="afterMain",ot="beforeWrite",at="write",it="afterWrite",st=[Qe,Ze,et,tt,rt,nt,ot,at,it];function W(t){return t?(t.nodeName||"").toLowerCase():null}function T(t){if(t==null)return window;if(t.toString()!=="[object Window]"){var e=t.ownerDocument;return e&&e.defaultView||window}return t}function oe(t){var e=T(t).Element;return t instanceof e||t instanceof Element}function M(t){var e=T(t).HTMLElement;return t instanceof e||t instanceof HTMLElement}function ft(t){if(typeof ShadowRoot>"u")return!1;var e=T(t).ShadowRoot;return t instanceof e||t instanceof ShadowRoot}function Et(t){var e=t.state;Object.keys(e.elements).forEach(function(r){var n=e.styles[r]||{},o=e.attributes[r]||{},a=e.elements[r];!M(a)||!W(a)||(Object.assign(a.style,n),Object.keys(o).forEach(function(s){var i=o[s];i===!1?a.removeAttribute(s):a.setAttribute(s,i===!0?"":i)}))})}function Pt(t){var e=t.state,r={popper:{position:e.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(e.elements.popper.style,r.popper),e.styles=r,e.elements.arrow&&Object.assign(e.elements.arrow.style,r.arrow),function(){Object.keys(e.elements).forEach(function(n){var o=e.elements[n],a=e.attributes[n]||{},s=Object.keys(e.styles.hasOwnProperty(n)?e.styles[n]:r[n]),i=s.reduce(function(c,p){return c[p]="",c},{});!M(o)||!W(o)||(Object.assign(o.style,i),Object.keys(a).forEach(function(c){o.removeAttribute(c)}))})}}const Ae={name:"applyStyles",enabled:!0,phase:"write",fn:Et,effect:Pt,requires:["computeStyles"]};function L(t){return t.split("-")[0]}function K(t,e){var r=t.getBoundingClientRect(),n=1,o=1;return{width:r.width/n,height:r.height/o,top:r.top/o,right:r.right/n,bottom:r.bottom/o,left:r.left/n,x:r.left/n,y:r.top/o}}function De(t){var e=K(t),r=t.offsetWidth,n=t.offsetHeight;return Math.abs(e.width-r)<=1&&(r=e.width),Math.abs(e.height-n)<=1&&(n=e.height),{x:t.offsetLeft,y:t.offsetTop,width:r,height:n}}function ct(t,e){var r=e.getRootNode&&e.getRootNode();if(t.contains(e))return!0;if(r&&ft(r)){var n=e;do{if(n&&t.isSameNode(n))return!0;n=n.parentNode||n.host}while(n)}return!1}function H(t){return T(t).getComputedStyle(t)}function jt(t){return["table","td","th"].indexOf(W(t))>=0}function F(t){return((oe(t)?t.ownerDocument:t.document)||window.document).documentElement}function he(t){return W(t)==="html"?t:t.assignedSlot||t.parentNode||(ft(t)?t.host:null)||F(t)}function Ve(t){return!M(t)||H(t).position==="fixed"?null:t.offsetParent}function At(t){var e=navigator.userAgent.toLowerCase().indexOf("firefox")!==-1,r=navigator.userAgent.indexOf("Trident")!==-1;if(r&&M(t)){var n=H(t);if(n.position==="fixed")return null}for(var o=he(t);M(o)&&["html","body"].indexOf(W(o))<0;){var a=H(o);if(a.transform!=="none"||a.perspective!=="none"||a.contain==="paint"||["transform","perspective"].indexOf(a.willChange)!==-1||e&&a.willChange==="filter"||e&&a.filter&&a.filter!=="none")return o;o=o.parentNode}return null}function ie(t){for(var e=T(t),r=Ve(t);r&&jt(r)&&H(r).position==="static";)r=Ve(r);return r&&(W(r)==="html"||W(r)==="body"&&H(r).position==="static")?e:r||At(t)||e}function $e(t){return["top","bottom"].indexOf(t)>=0?"x":"y"}var N=Math.max,ae=Math.min,ue=Math.round;function ve(t,e,r){return N(t,ae(e,r))}function pt(){return{top:0,right:0,bottom:0,left:0}}function ut(t){return Object.assign({},pt(),t)}function lt(t,e){return e.reduce(function(r,n){return r[n]=t,r},{})}var Dt=function(e,r){return e=typeof e=="function"?e(Object.assign({},r.rects,{placement:r.placement})):e,ut(typeof e!="number"?e:lt(e,ee))};function $t(t){var e,r=t.state,n=t.name,o=t.options,a=r.elements.arrow,s=r.modifiersData.popperOffsets,i=L(r.placement),c=$e(i),p=[$,S].indexOf(i)>=0,f=p?"height":"width";if(!(!a||!s)){var m=Dt(o.padding,r),E=De(a),l=c==="y"?D:$,h=c==="y"?R:S,d=r.rects.reference[f]+r.rects.reference[c]-s[c]-r.rects.popper[f],v=s[c]-r.rects.reference[c],x=ie(a),g=x?c==="y"?x.clientHeight||0:x.clientWidth||0:0,b=d/2-v/2,u=m[l],w=g-E[f]-m[h],y=g/2-E[f]/2+b,O=ve(u,y,w),j=c;r.modifiersData[n]=(e={},e[j]=O,e.centerOffset=O-y,e)}}function Rt(t){var e=t.state,r=t.options,n=r.element,o=n===void 0?"[data-popper-arrow]":n;o!=null&&(typeof o=="string"&&(o=e.elements.popper.querySelector(o),!o)||ct(e.elements.popper,o)&&(e.elements.arrow=o))}const vt={name:"arrow",enabled:!0,phase:"main",fn:$t,effect:Rt,requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};function Q(t){return t.split("-")[1]}var St={top:"auto",right:"auto",bottom:"auto",left:"auto"};function Bt(t){var e=t.x,r=t.y,n=window,o=n.devicePixelRatio||1;return{x:ue(ue(e*o)/o)||0,y:ue(ue(r*o)/o)||0}}function Xe(t){var e,r=t.popper,n=t.popperRect,o=t.placement,a=t.variation,s=t.offsets,i=t.position,c=t.gpuAcceleration,p=t.adaptive,f=t.roundOffsets,m=f===!0?Bt(s):typeof f=="function"?f(s):s,E=m.x,l=E===void 0?0:E,h=m.y,d=h===void 0?0:h,v=s.hasOwnProperty("x"),x=s.hasOwnProperty("y"),g=$,b=D,u=window;if(p){var w=ie(r),y="clientHeight",O="clientWidth";w===T(r)&&(w=F(r),H(w).position!=="static"&&i==="absolute"&&(y="scrollHeight",O="scrollWidth")),w=w,(o===D||(o===$||o===S)&&a===J)&&(b=R,d-=w[y]-n.height,d*=c?1:-1),(o===$||(o===D||o===R)&&a===J)&&(g=S,l-=w[O]-n.width,l*=c?1:-1)}var j=Object.assign({position:i},p&&St);if(c){var P;return Object.assign({},j,(P={},P[b]=x?"0":"",P[g]=v?"0":"",P.transform=(u.devicePixelRatio||1)<=1?"translate("+l+"px, "+d+"px)":"translate3d("+l+"px, "+d+"px, 0)",P))}return Object.assign({},j,(e={},e[b]=x?d+"px":"",e[g]=v?l+"px":"",e.transform="",e))}function Ct(t){var e=t.state,r=t.options,n=r.gpuAcceleration,o=n===void 0?!0:n,a=r.adaptive,s=a===void 0?!0:a,i=r.roundOffsets,c=i===void 0?!0:i,p={placement:L(e.placement),variation:Q(e.placement),popper:e.elements.popper,popperRect:e.rects.popper,gpuAcceleration:o};e.modifiersData.popperOffsets!=null&&(e.styles.popper=Object.assign({},e.styles.popper,Xe(Object.assign({},p,{offsets:e.modifiersData.popperOffsets,position:e.options.strategy,adaptive:s,roundOffsets:c})))),e.modifiersData.arrow!=null&&(e.styles.arrow=Object.assign({},e.styles.arrow,Xe(Object.assign({},p,{offsets:e.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:c})))),e.attributes.popper=Object.assign({},e.attributes.popper,{"data-popper-placement":e.placement})}const Re={name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:Ct,data:{}};var le={passive:!0};function Mt(t){var e=t.state,r=t.instance,n=t.options,o=n.scroll,a=o===void 0?!0:o,s=n.resize,i=s===void 0?!0:s,c=T(e.elements.popper),p=[].concat(e.scrollParents.reference,e.scrollParents.popper);return a&&p.forEach(function(f){f.addEventListener("scroll",r.update,le)}),i&&c.addEventListener("resize",r.update,le),function(){a&&p.forEach(function(f){f.removeEventListener("scroll",r.update,le)}),i&&c.removeEventListener("resize",r.update,le)}}const Se={name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:Mt,data:{}};var Tt={left:"right",right:"left",bottom:"top",top:"bottom"};function de(t){return t.replace(/left|right|bottom|top/g,function(e){return Tt[e]})}var kt={start:"end",end:"start"};function Ye(t){return t.replace(/start|end/g,function(e){return kt[e]})}function Be(t){var e=T(t),r=e.pageXOffset,n=e.pageYOffset;return{scrollLeft:r,scrollTop:n}}function Ce(t){return K(F(t)).left+Be(t).scrollLeft}function Lt(t){var e=T(t),r=F(t),n=e.visualViewport,o=r.clientWidth,a=r.clientHeight,s=0,i=0;return n&&(o=n.width,a=n.height,/^((?!chrome|android).)*safari/i.test(navigator.userAgent)||(s=n.offsetLeft,i=n.offsetTop)),{width:o,height:a,x:s+Ce(t),y:i}}function Wt(t){var e,r=F(t),n=Be(t),o=(e=t.ownerDocument)==null?void 0:e.body,a=N(r.scrollWidth,r.clientWidth,o?o.scrollWidth:0,o?o.clientWidth:0),s=N(r.scrollHeight,r.clientHeight,o?o.scrollHeight:0,o?o.clientHeight:0),i=-n.scrollLeft+Ce(t),c=-n.scrollTop;return H(o||r).direction==="rtl"&&(i+=N(r.clientWidth,o?o.clientWidth:0)-a),{width:a,height:s,x:i,y:c}}function Me(t){var e=H(t),r=e.overflow,n=e.overflowX,o=e.overflowY;return/auto|scroll|overlay|hidden/.test(r+o+n)}function dt(t){return["html","body","#document"].indexOf(W(t))>=0?t.ownerDocument.body:M(t)&&Me(t)?t:dt(he(t))}function ne(t,e){var r;e===void 0&&(e=[]);var n=dt(t),o=n===((r=t.ownerDocument)==null?void 0:r.body),a=T(n),s=o?[a].concat(a.visualViewport||[],Me(n)?n:[]):n,i=e.concat(s);return o?i:i.concat(ne(he(s)))}function Ee(t){return Object.assign({},t,{left:t.x,top:t.y,right:t.x+t.width,bottom:t.y+t.height})}function Ht(t){var e=K(t);return e.top=e.top+t.clientTop,e.left=e.left+t.clientLeft,e.bottom=e.top+t.clientHeight,e.right=e.left+t.clientWidth,e.width=t.clientWidth,e.height=t.clientHeight,e.x=e.left,e.y=e.top,e}function Ie(t,e){return e===Pe?Ee(Lt(t)):M(e)?Ht(e):Ee(Wt(F(t)))}function Nt(t){var e=ne(he(t)),r=["absolute","fixed"].indexOf(H(t).position)>=0,n=r&&M(t)?ie(t):t;return oe(n)?e.filter(function(o){return oe(o)&&ct(o,n)&&W(o)!=="body"}):[]}function Ft(t,e,r){var n=e==="clippingParents"?Nt(t):[].concat(e),o=[].concat(n,[r]),a=o[0],s=o.reduce(function(i,c){var p=Ie(t,c);return i.top=N(p.top,i.top),i.right=ae(p.right,i.right),i.bottom=ae(p.bottom,i.bottom),i.left=N(p.left,i.left),i},Ie(t,a));return s.width=s.right-s.left,s.height=s.bottom-s.top,s.x=s.left,s.y=s.top,s}function mt(t){var e=t.reference,r=t.element,n=t.placement,o=n?L(n):null,a=n?Q(n):null,s=e.x+e.width/2-r.width/2,i=e.y+e.height/2-r.height/2,c;switch(o){case D:c={x:s,y:e.y-r.height};break;case R:c={x:s,y:e.y+e.height};break;case S:c={x:e.x+e.width,y:i};break;case $:c={x:e.x-r.width,y:i};break;default:c={x:e.x,y:e.y}}var p=o?$e(o):null;if(p!=null){var f=p==="y"?"height":"width";switch(a){case Y:c[p]=c[p]-(e[f]/2-r[f]/2);break;case J:c[p]=c[p]+(e[f]/2-r[f]/2);break}}return c}function Z(t,e){e===void 0&&(e={});var r=e,n=r.placement,o=n===void 0?t.placement:n,a=r.boundary,s=a===void 0?Je:a,i=r.rootBoundary,c=i===void 0?Pe:i,p=r.elementContext,f=p===void 0?G:p,m=r.altBoundary,E=m===void 0?!1:m,l=r.padding,h=l===void 0?0:l,d=ut(typeof h!="number"?h:lt(h,ee)),v=f===G?Ke:G,x=t.rects.popper,g=t.elements[E?v:f],b=Ft(oe(g)?g:g.contextElement||F(t.elements.popper),s,c),u=K(t.elements.reference),w=mt({reference:u,element:x,strategy:"absolute",placement:o}),y=Ee(Object.assign({},x,w)),O=f===G?y:u,j={top:b.top-O.top+d.top,bottom:O.bottom-b.bottom+d.bottom,left:b.left-O.left+d.left,right:O.right-b.right+d.right},P=t.modifiersData.offset;if(f===G&&P){var B=P[o];Object.keys(j).forEach(function(C){var q=[S,R].indexOf(C)>=0?1:-1,A=[D,R].indexOf(C)>=0?"y":"x";j[C]+=B[A]*q})}return j}function qt(t,e){e===void 0&&(e={});var r=e,n=r.placement,o=r.boundary,a=r.rootBoundary,s=r.padding,i=r.flipVariations,c=r.allowedAutoPlacements,p=c===void 0?je:c,f=Q(n),m=f?i?xe:xe.filter(function(h){return Q(h)===f}):ee,E=m.filter(function(h){return p.indexOf(h)>=0});E.length===0&&(E=m);var l=E.reduce(function(h,d){return h[d]=Z(t,{placement:d,boundary:o,rootBoundary:a,padding:s})[L(d)],h},{});return Object.keys(l).sort(function(h,d){return l[h]-l[d]})}function Vt(t){if(L(t)===me)return[];var e=de(t);return[Ye(t),e,Ye(e)]}function Xt(t){var e=t.state,r=t.options,n=t.name;if(!e.modifiersData[n]._skip){for(var o=r.mainAxis,a=o===void 0?!0:o,s=r.altAxis,i=s===void 0?!0:s,c=r.fallbackPlacements,p=r.padding,f=r.boundary,m=r.rootBoundary,E=r.altBoundary,l=r.flipVariations,h=l===void 0?!0:l,d=r.allowedAutoPlacements,v=e.options.placement,x=L(v),g=x===v,b=c||(g||!h?[de(v)]:Vt(v)),u=[v].concat(b).reduce(function(X,k){return X.concat(L(k)===me?qt(e,{placement:k,boundary:f,rootBoundary:m,padding:p,flipVariations:h,allowedAutoPlacements:d}):k)},[]),w=e.rects.reference,y=e.rects.popper,O=new Map,j=!0,P=u[0],B=0;B<u.length;B++){var C=u[B],q=L(C),A=Q(C)===Y,te=[D,R].indexOf(q)>=0,re=te?"width":"height",I=Z(e,{placement:C,boundary:f,rootBoundary:m,altBoundary:E,padding:p}),V=te?A?S:$:A?R:D;w[re]>y[re]&&(V=de(V));var ye=de(V),z=[];if(a&&z.push(I[q]<=0),i&&z.push(I[V]<=0,I[ye]<=0),z.every(function(X){return X})){P=C,j=!1;break}O.set(C,z)}if(j)for(var se=h?3:1,be=function(k){var ce=u.find(function(we){var _=O.get(we);if(_)return _.slice(0,k).every(function(Oe){return Oe})});if(ce)return P=ce,"break"},U=se;U>0;U--){var fe=be(U);if(fe==="break")break}e.placement!==P&&(e.modifiersData[n]._skip=!0,e.placement=P,e.reset=!0)}}const ht={name:"flip",enabled:!0,phase:"main",fn:Xt,requiresIfExists:["offset"],data:{_skip:!1}};function ze(t,e,r){return r===void 0&&(r={x:0,y:0}),{top:t.top-e.height-r.y,right:t.right-e.width+r.x,bottom:t.bottom-e.height+r.y,left:t.left-e.width-r.x}}function Ue(t){return[D,S,R,$].some(function(e){return t[e]>=0})}function Yt(t){var e=t.state,r=t.name,n=e.rects.reference,o=e.rects.popper,a=e.modifiersData.preventOverflow,s=Z(e,{elementContext:"reference"}),i=Z(e,{altBoundary:!0}),c=ze(s,n),p=ze(i,o,a),f=Ue(c),m=Ue(p);e.modifiersData[r]={referenceClippingOffsets:c,popperEscapeOffsets:p,isReferenceHidden:f,hasPopperEscaped:m},e.attributes.popper=Object.assign({},e.attributes.popper,{"data-popper-reference-hidden":f,"data-popper-escaped":m})}const gt={name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:Yt};function It(t,e,r){var n=L(t),o=[$,D].indexOf(n)>=0?-1:1,a=typeof r=="function"?r(Object.assign({},e,{placement:t})):r,s=a[0],i=a[1];return s=s||0,i=(i||0)*o,[$,S].indexOf(n)>=0?{x:i,y:s}:{x:s,y:i}}function zt(t){var e=t.state,r=t.options,n=t.name,o=r.offset,a=o===void 0?[0,0]:o,s=je.reduce(function(f,m){return f[m]=It(m,e.rects,a),f},{}),i=s[e.placement],c=i.x,p=i.y;e.modifiersData.popperOffsets!=null&&(e.modifiersData.popperOffsets.x+=c,e.modifiersData.popperOffsets.y+=p),e.modifiersData[n]=s}const yt={name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:zt};function Ut(t){var e=t.state,r=t.name;e.modifiersData[r]=mt({reference:e.rects.reference,element:e.rects.popper,strategy:"absolute",placement:e.placement})}const Te={name:"popperOffsets",enabled:!0,phase:"read",fn:Ut,data:{}};function _t(t){return t==="x"?"y":"x"}function Gt(t){var e=t.state,r=t.options,n=t.name,o=r.mainAxis,a=o===void 0?!0:o,s=r.altAxis,i=s===void 0?!1:s,c=r.boundary,p=r.rootBoundary,f=r.altBoundary,m=r.padding,E=r.tether,l=E===void 0?!0:E,h=r.tetherOffset,d=h===void 0?0:h,v=Z(e,{boundary:c,rootBoundary:p,padding:m,altBoundary:f}),x=L(e.placement),g=Q(e.placement),b=!g,u=$e(x),w=_t(u),y=e.modifiersData.popperOffsets,O=e.rects.reference,j=e.rects.popper,P=typeof d=="function"?d(Object.assign({},e.rects,{placement:e.placement})):d,B={x:0,y:0};if(y){if(a||i){var C=u==="y"?D:$,q=u==="y"?R:S,A=u==="y"?"height":"width",te=y[u],re=y[u]+v[C],I=y[u]-v[q],V=l?-j[A]/2:0,ye=g===Y?O[A]:j[A],z=g===Y?-j[A]:-O[A],se=e.elements.arrow,be=l&&se?De(se):{width:0,height:0},U=e.modifiersData["arrow#persistent"]?e.modifiersData["arrow#persistent"].padding:pt(),fe=U[C],X=U[q],k=ve(0,O[A],be[A]),ce=b?O[A]/2-V-k-fe-P:ye-k-fe-P,we=b?-O[A]/2+V+k+X+P:z+k+X+P,_=e.elements.arrow&&ie(e.elements.arrow),Oe=_?u==="y"?_.clientTop||0:_.clientLeft||0:0,ke=e.modifiersData.offset?e.modifiersData.offset[e.placement][u]:0,Le=y[u]+ce-ke-Oe,We=y[u]+we-ke;if(a){var He=ve(l?ae(re,Le):re,te,l?N(I,We):I);y[u]=He,B[u]=He-te}if(i){var wt=u==="x"?D:$,Ot=u==="x"?R:S,pe=y[w],Ne=pe+v[wt],Fe=pe-v[Ot],qe=ve(l?ae(Ne,Le):Ne,pe,l?N(Fe,We):Fe);y[w]=qe,B[w]=qe-pe}}e.modifiersData[n]=B}}const bt={name:"preventOverflow",enabled:!0,phase:"main",fn:Gt,requiresIfExists:["offset"]};function Jt(t){return{scrollLeft:t.scrollLeft,scrollTop:t.scrollTop}}function Kt(t){return t===T(t)||!M(t)?Be(t):Jt(t)}function Qt(t){var e=t.getBoundingClientRect(),r=e.width/t.offsetWidth||1,n=e.height/t.offsetHeight||1;return r!==1||n!==1}function Zt(t,e,r){r===void 0&&(r=!1);var n=M(e);M(e)&&Qt(e);var o=F(e),a=K(t),s={scrollLeft:0,scrollTop:0},i={x:0,y:0};return(n||!n&&!r)&&((W(e)!=="body"||Me(o))&&(s=Kt(e)),M(e)?(i=K(e),i.x+=e.clientLeft,i.y+=e.clientTop):o&&(i.x=Ce(o))),{x:a.left+s.scrollLeft-i.x,y:a.top+s.scrollTop-i.y,width:a.width,height:a.height}}function er(t){var e=new Map,r=new Set,n=[];t.forEach(function(a){e.set(a.name,a)});function o(a){r.add(a.name);var s=[].concat(a.requires||[],a.requiresIfExists||[]);s.forEach(function(i){if(!r.has(i)){var c=e.get(i);c&&o(c)}}),n.push(a)}return t.forEach(function(a){r.has(a.name)||o(a)}),n}function tr(t){var e=er(t);return st.reduce(function(r,n){return r.concat(e.filter(function(o){return o.phase===n}))},[])}function rr(t){var e;return function(){return e||(e=new Promise(function(r){Promise.resolve().then(function(){e=void 0,r(t())})})),e}}function nr(t){var e=t.reduce(function(r,n){var o=r[n.name];return r[n.name]=o?Object.assign({},o,n,{options:Object.assign({},o.options,n.options),data:Object.assign({},o.data,n.data)}):n,r},{});return Object.keys(e).map(function(r){return e[r]})}var _e={placement:"bottom",modifiers:[],strategy:"absolute"};function Ge(){for(var t=arguments.length,e=new Array(t),r=0;r<t;r++)e[r]=arguments[r];return!e.some(function(n){return!(n&&typeof n.getBoundingClientRect=="function")})}function ge(t){t===void 0&&(t={});var e=t,r=e.defaultModifiers,n=r===void 0?[]:r,o=e.defaultOptions,a=o===void 0?_e:o;return function(i,c,p){p===void 0&&(p=a);var f={placement:"bottom",orderedModifiers:[],options:Object.assign({},_e,a),modifiersData:{},elements:{reference:i,popper:c},attributes:{},styles:{}},m=[],E=!1,l={state:f,setOptions:function(x){var g=typeof x=="function"?x(f.options):x;d(),f.options=Object.assign({},a,f.options,g),f.scrollParents={reference:oe(i)?ne(i):i.contextElement?ne(i.contextElement):[],popper:ne(c)};var b=tr(nr([].concat(n,f.options.modifiers)));return f.orderedModifiers=b.filter(function(u){return u.enabled}),h(),l.update()},forceUpdate:function(){if(!E){var x=f.elements,g=x.reference,b=x.popper;if(Ge(g,b)){f.rects={reference:Zt(g,ie(b),f.options.strategy==="fixed"),popper:De(b)},f.reset=!1,f.placement=f.options.placement,f.orderedModifiers.forEach(function(B){return f.modifiersData[B.name]=Object.assign({},B.data)});for(var u=0;u<f.orderedModifiers.length;u++){if(f.reset===!0){f.reset=!1,u=-1;continue}var w=f.orderedModifiers[u],y=w.fn,O=w.options,j=O===void 0?{}:O,P=w.name;typeof y=="function"&&(f=y({state:f,options:j,name:P,instance:l})||f)}}}},update:rr(function(){return new Promise(function(v){l.forceUpdate(),v(f)})}),destroy:function(){d(),E=!0}};if(!Ge(i,c))return l;l.setOptions(p).then(function(v){!E&&p.onFirstUpdate&&p.onFirstUpdate(v)});function h(){f.orderedModifiers.forEach(function(v){var x=v.name,g=v.options,b=g===void 0?{}:g,u=v.effect;if(typeof u=="function"){var w=u({state:f,name:x,instance:l,options:b}),y=function(){};m.push(w||y)}})}function d(){m.forEach(function(v){return v()}),m=[]}return l}}var or=ge(),ar=[Se,Te,Re,Ae],ir=ge({defaultModifiers:ar}),sr=[Se,Te,Re,Ae,yt,ht,bt,vt,gt],fr=ge({defaultModifiers:sr});const cr=Object.freeze(Object.defineProperty({__proto__:null,afterMain:nt,afterRead:et,afterWrite:it,applyStyles:Ae,arrow:vt,auto:me,basePlacements:ee,beforeMain:tt,beforeRead:Qe,beforeWrite:ot,bottom:R,clippingParents:Je,computeStyles:Re,createPopper:fr,createPopperBase:or,createPopperLite:ir,detectOverflow:Z,end:J,eventListeners:Se,flip:ht,hide:gt,left:$,main:rt,modifierPhases:st,offset:yt,placements:je,popper:G,popperGenerator:ge,popperOffsets:Te,preventOverflow:bt,read:Ze,reference:Ke,right:S,start:Y,top:D,variationPlacements:xe,viewport:Pe,write:at},Symbol.toStringTag,{value:"Module"})),lr=xt(cr);export{xt as a,pr as c,ur as g,lr as r};
