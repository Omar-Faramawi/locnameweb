<div class="feedback_title "><span class="">Feedback</span></div>

<form id="feedback_me_form"><ul>
        <li>	
            <label for="feedback_name">Name</label>
            <span class="required_asterisk">*</span>
            <input type="text" id="feedback_name" required="" placeholder="Name please" data-toggle="tooltip"  data-placement="left" title="Enter Your Name">
        </li>
        <li>	
            <label for="feedback_email">Email</label>
            <span class="required_asterisk">*</span> 
            <input type="email" id="feedback_email" required="" placeholder="">
        </li>
        <li>	
            <label for="feedback_message">Message</label>
            <span class="required_asterisk">*</span> 
            <textarea rows="5" id="feedback_message" required="" placeholder="Go ahead, type your feedback or report  here..."></textarea>
        </li>
        <li>
            <button id="feedback_submit" type="submit" onclick="fm.sendFeedback(event);" class=" btn btn-primary ">Send</button>
        </li>
    </ul>
</form>
