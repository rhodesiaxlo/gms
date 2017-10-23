<table width="100%">
  <tr>
    <th>数据来源:</th>
    <td><select name="extra[type]" class="easyui-combobox" data-options="value:'Option',editable:false" style="height:30px">
        <option value="Option">选项</option>
        <option value="Config">配置</option>
        <option value="Function">方法</option>
      </select></td>
  </tr>
  <tr>
    <th></th>
    <td>选择数据来源后，根据类型在下面的参数中输入相应的值<br/>
    1> 选项：例(选项值1:选项名1|选项值2:选项名2)<br/>
    2> 配置：例(FIELD_LIST),其中FIELD_LIST是配置名称<br/>
    3> 方法：例(Admin/AuthGroup/get_auth_role)方法名称
    </td>
  </tr>
  <tr>
    <th>参数:</th>
    <td><textarea name="extra[option]" class="easyui-textbox" data-options="multiline:true" style="width:300px;height:80px"></textarea></td>
  </tr>
  <tr>
    <th>下拉框类型:</th>
    <td><select name="extra[form_type]" class="easyui-combobox" data-options="value:'1',editable:false" style="height:30px">
        <option value="1">普通列表</option>
        <option value="2">树形列表</option>
      </select></td>
  </tr>
  <tr>
    <th>是否支持多选:</th>
    <td><select name="extra[multiple]" class="easyui-combobox" data-options="editable:false" style="height:30px">
        <option value="0">单选</option>
        <option value="1">多选</option>
      </select></td>
  </tr>
  <tr>
    <th>是否允许手写输入:</th>
    <td><select name="extra[editable]" class="easyui-combobox" data-options="editable:false" style="height:30px">
        <option value="false">否</option>
        <option value="true">是</option>
      </select></td>
  </tr>
  <tr>
    <th>是否必填:</th>
    <td><select name="extra[required]" class="easyui-combobox" data-options="editable:false" style="height:30px">
        <option value="0" selected="selected">否</option>
        <option value="1">是</option>
      </select></td>
  </tr>
  <tr>
    <th>表单样式</th>
    <td><textarea name="extra[style]" class="easyui-textbox" data-options="multiline:true" style="width:300px; height:100px;">height:30px;</textarea></td>
  </tr>
</table>