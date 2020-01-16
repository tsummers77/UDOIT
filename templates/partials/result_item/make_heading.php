<?php
/**
*	Copyright (C) 2014 University of Central Florida, created by Jacob Bates, Eric Colon, Fenel Joseph, and Emily Sachs.
*
*	This program is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*	Primary Author Contact:  Jacob Bates <jacob.bates@ucf.edu>
*/
?>
<div class="input-group">
	<label for="<?= $this->e($item_id); ?>-input" class="control-label sr-only">Select which heading the paragraph should be</label>
	<select class="form-control" name="newcontent" id="<?= $this->e($item_id); ?>-input">
		<option value="h2">h2</option>
		<option value="h3">h3</option>
		<option value="h4">h4</option>
	</select>
	<span class="input-group-btn">
		<button class="submit-content inactive btn btn-default" type="submit">Submit</button>
	</span>
</div>
