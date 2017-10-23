<table width="100%">
  <tr>
    <th>表单类型:</th>
    <td><select name="extra[from_type]" class="easyui-combobox">
        <option value="datebox" <?php if($_Extra['from_type']=='datebox'){?>selected="selected"<?php }?>>日期</option>
        <option value="datetimebox" <?php if($_Extra['from_type']=='datetimebox'){?>selected="selected"<?php }?>>日期时间</option>
      </select></td>
  </tr>
  <tr>
    <th>是否必填:</th>
    <td><select name="extra[required]" class="easyui-combobox">
        <option value="0" <?php if($_Extra['required']=='0'){?>selected="selected"<?php }?>>否</option>
        <option value="1" <?php if($_Extra['required']=='1'){?>selected="selected"<?php }?>>是</option>
      </select></td>
  </tr>
  <tr>
    <th>新增为当前时间:</th>
    <td><select name="extra[add_time]" class="easyui-combobox">
        <option value="0" <?php if($_Extra['add_time']=='0'){?>selected="selected"<?php }?>>否</option>
        <option value="1" <?php if($_Extra['add_time']=='1'){?>selected="selected"<?php }?>>是</option>
      </select></td>
  </tr>
  <tr>
    <th>表单样式</th>
    <td><textarea name="extra[style]" class="easyui-textbox" data-options="multiline:true" style="width:300px; height:100px;"><?php echo $_Extra['style'];?></textarea></td>
  </tr>
</table>