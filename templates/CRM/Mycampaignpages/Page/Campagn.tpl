<div id="help">
    {ts}This Page lists all Personal Campaigns created by you.{/ts}
</div>

{include file="CRM/common/jsortable.tpl"}

{if $pcpCount>0}
{strip}
<table id="options" class="display">
    <thead>
    <tr>
        <th id="sortable">{ts}Title{/ts}</th>
        <th>{ts}Contribution Page/Event{/ts}</th>
        <th>{ts}Status{/ts}</th>
        <th>{ts}Contributions{/ts}</th>
        <th>{ts}Raised{/ts}</th>
        <th>{ts}Target{/ts}</th>
        <th></th>
    </tr>
    </thead>

    {foreach from=$personalCampaigns item=row}


       <tr id="personal-campaign-{$row.id}" class="crm-entity {$row.class}{if NOT $row.is_active} disabled{/if}">
        <td class=""><a href="{crmURL p='civicrm/pcp/info' q="reset=1&id=`$row.id`"}">{$row.title} <br/> {$row.intro_text}</a></td>
        <td class="right"><a href="{crmURL p="`$row.baseUrl`" q="id=`$row.page_id`&reset=1"}">{$row.parent.title}</a></td>
        <td class="right">{$pcp_status[$row.status_id]}</td>
        <td class="right"><a href="javascript:postSearch('{crmURL p="civicrm/contact/search/advanced" q="force=1&reset=1"}',{$row.id})">{$row.contributors}</a></td>
        <td>{$row.raised}</td>
        <td>{$row.goal_amount}</td>
        <td><a href="{crmURL p='civicrm/pcp/info' q="id=`$row.id`&reset=1&action=update&context=dashboard"}">Edit</a> </td>
        </tr>

        <!--<tr>
            <td>$row</td>
        </tr>-->

    {/foreach}

    </table>
{/strip}

{else}
    <div class="messages status no-popup">
        <div class="icon inform-icon"></div>
        {ts}You have not created any Personal campaigns.{/ts}
    </div>

{/if}

<p></p>
<div class="action-link">
    <a href='{crmURL p='civicrm/contribute/campaign' q="reset=1&action=add&pageId=1&component=contribute"}' id="newDiscountCode"
       class="button"><span class="icon ui-icon-circle-plus"></span> {ts}Create Personal Contribution{/ts}</a>
    <a href='{crmURL p='civicrm/event/campaign' q="reset=1&action=add&pageId=1&component=contribute"}' id="newDiscountCode"
       class="button"><span class="icon ui-icon-circle-plus"></span> {ts}Create Personal Event{/ts}</a>
</div>
<!--<td class="right"><a onclick="{crmURL p="civicrm/contact/search/advanced" q="=`$row.id`&component_mode=2&force=1&contribution_or_softcredits=both&reset=1"}">{$row.contributors}</a></td>-->

{literal}
<script>
    function postSearch(link,id){
        var f = document.createElement('form');
        f.method = 'post';
        f.action = link;
        var c = document.createElement('input');
        c.type='text';
        c.name = 'component_mode';
        c.value = 2;
        f.appendChild(c);
        var p = document.createElement('input');
        p.type  = 'text';
        p.name = 'contribution_pcp_made_through_id[]';
        p.value = id;
        f.appendChild(p);
        var s = document.createElement('input');
        s.type = 'submit';
        f.appendChild(s);
        document.body.appendChild(f);
        f.submit();
    }
</script>
{/literal}


