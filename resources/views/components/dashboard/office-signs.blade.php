<div class="tooltip-main w-3/4">
    <img alt="desk"
         @switch($direction)
             @case("right")
                 src="/img/desk-side.png" class="desk-horizontal-right desk-horizental-responsive">
                     <div class="relative bottom-5" style="right:450%!important;">
                         <span class="tooltip" >{{ showDetails($space) }}</span>
                     </div>

         @break

         @case("left")
             src="/img/desk-side.png" class="desk-horizental desk-horizental-responsive">
                 <div class="relative bottom-5" style="left:150%!important;">
                      <span class="tooltip" >{{ showDetails($space) }}</span>
                 </div>

         @break

         @default
             src="/img/desk-front.png" class="align-middle desk-vertical-responsive">
               <div class="relative z-50 left-3 bottom-5" >
                      <span class="tooltip" >{{ showDetails($space) }}</span>
                 </div>
        @endswitch
</div>

