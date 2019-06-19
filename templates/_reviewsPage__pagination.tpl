{if $countReviewsPages}
    <span>Страница: </span>
    <div id="pagination">
        <ul class="pagination">
            {section name=foo start=1 loop=$countReviewsPages step=1}
                {if ($smarty.section.foo.index eq $currentPage)}
                    <li class="active">
                        <a href="#">{$smarty.section.foo.index}</a>
                    </li>
                {else}
                    <li>
                        <a href="/otzyvy/{if $painCpu}{$painCpu}/{/if}?page={$smarty.section.foo.index}">{$smarty.section.foo.index}</a>
                    </li>
                {/if}
            {/section}
        </ul>
    </div>
{/if}