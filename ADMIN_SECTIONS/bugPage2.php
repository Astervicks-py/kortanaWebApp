<form class="bugPage" style="display:none"  id="addBugReport" action="#" method="post">
    <table>
        <thead>
            <tr>
                <th>Column</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <label for="">TITLE: </label>  
                </th>
                <td>
                    <input type="text" name="title" id="title">
                </td>
            </tr>

            <tr class="tr_light">
                <th>
                    <label for="">DESCRIPTION: </label>  
                </th>
                <td>
                    <textarea name="description" id="description" cols="30" rows="10" resize="none"></textarea>
                </td>
            </tr>

            <tr>
                <th>
                    <label for="">IDEA (if any): </label>
                </th>
                <td>
                    <textarea name="idea" id="idea" cols="30" rows="10" resize="none"></textarea>
                </td>
            </tr>

            <tr class="tr_light">
                <th>
                    <label for="">CODE LINE: </label>
                </th>
                <td>
                    <input type="number" name="line" id="line">
                </td>
            </tr>

            <tr>
                <th>
                    <label for="">FILE/PAGE: </label>
                </th>
                <td>
                    <input type="text" name="filename" id="filename">
                </td>
            </tr>

            <tr class="tr_light">
                <th>
                    <label for="">IMPORTANT: </label>
                </th>
                <td>
                    <input type="checkbox" checked name="important" id="important">
                </td>
            </tr>
            
        </tbody>
        
    </table>
    <div class="submit-btn">
        <input type="submit" name="submit" id="submit" value="ADD">
    </div>
    
</form>