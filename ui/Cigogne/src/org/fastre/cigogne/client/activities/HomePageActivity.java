/**
 * 
 */
package org.fastre.cigogne.client.activities;

import org.fastre.cigogne.client.ClientFactory;

import com.google.gwt.activity.shared.AbstractActivity;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.AcceptsOneWidget;

/**
 * @author Julien Fastré
 * 24 déc. 2012
 *
 */
public class HomePageActivity extends AbstractActivity {
	
	public interface HomePageActivityView {
		
	}
	
	private ClientFactory clientFactory;

	public HomePageActivity(ClientFactory clientFactory) {
		this.clientFactory = clientFactory;
	}

	/* (non-Javadoc)
	 * @see com.google.gwt.activity.shared.Activity#start(com.google.gwt.user.client.ui.AcceptsOneWidget, com.google.gwt.event.shared.EventBus)
	 */
	@Override
	public void start(AcceptsOneWidget panel, EventBus eventBus) {
		Window.alert("hello");

	}

}
