{include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0">
  <tr>
    <td width="45"><a href="index.php"><img src="images/icon_submission_id_manager.gif" border="0" width="34" height="34" /></a></td>
    <td class="title">
      <a href="../../admin/modules">{$LANG.word_modules}</a>
      <span class="joiner">&raquo;</span>
      {$L.module_name}
    </td>
  </tr>
  </table>

  {include file="messages.tpl"}

  <div class="margin_bottom_large">
    {$L.text_module_summary}
  </div>

  <table cellspacing="1" cellpadding="0" class="list_table margin_bottom_large">
  <tr>
    <th class="pad_left" style="text-align:left">{$L.phrase_change_submission_id}</th>
  </tr>
  <tr>
    <td valign="top">
      <form action="{$same_page}" id="change_submission_id_form" method="post">
        <table cellspacing="2" cellpadding="1">
        <tr>
          <td width="260">{$L.phrase_select_form}</td>
          <td>
            <select name="form_id">
              {foreach from=$dropdown_info key=k item=i}
                <option value="{$k}">{$i}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td valign="top">{$L.phrase_change_next_submission_id_to_c}</td>
          <td>
            <input type="text" name="next_submission_id" id="next_submission_id" size="10" />
          </td>
        </tr>
        </table>
        <div class="pad_top_large">
          <input type="submit" name="update" value="{$LANG.word_update}" />
        </div>
      </form>
    </td>
  </tr>
  </table>

  <table cellspacing="1" cellpadding="0" class="list_table margin_bottom_large">
  <tr>
    <th class="pad_left" style="text-align:left">{$L.phrase_delete_form_submissions_and_reset}</th>
  </tr>
  <tr>
    <td valign="top">
      <form action="{$same_page}" id="truncate_form" method="post">
        <input type="hidden" name="delete" value="1" />

        <table cellspacing="2" cellpadding="1">
        <tr>
          <td width="260">{$L.phrase_select_form}</td>
          <td>
            <select name="form_id">
              {foreach from=$dropdown_info key=k item=i}
                <option value="{$k}">{$i}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        </table>
        <div class="pad_top_large">
          <input type="button" id="delete" value="{$L.phrase_delete_submissions}" />
        </div>
      </form>
    </td>
  </tr>
  </table>

{include file='modules_footer.tpl'}
