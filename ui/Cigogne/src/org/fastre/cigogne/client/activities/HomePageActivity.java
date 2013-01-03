/**
 * 
 */
package org.fastre.cigogne.client.activities;

import org.fastre.cigogne.client.ClientFactory;
import org.fastre.cigogne.client.view.HomePageView;

import com.google.gwt.activity.shared.AbstractActivity;
import com.google.gwt.core.shared.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.regexp.shared.RegExp;
import com.google.gwt.regexp.shared.SplitResult;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.AcceptsOneWidget;

/**
 * @author Julien Fastré
 * 24 déc. 2012
 *
 */
public class HomePageActivity extends AbstractActivity {
	
	public interface HomePageActivityView {
		void setPresenter(HomePageActivity presenter);
	}
	
	private ClientFactory clientFactory;
	private HomePageView view;

	public HomePageActivity(ClientFactory clientFactory) {
		this.clientFactory = clientFactory;
		this.view = this.clientFactory.getHomePage();
		this.view.setPresenter(this);
		
	}

	/* (non-Javadoc)
	 * @see com.google.gwt.activity.shared.Activity#start(com.google.gwt.user.client.ui.AcceptsOneWidget, com.google.gwt.event.shared.EventBus)
	 */
	@Override
	public void start(AcceptsOneWidget panel, EventBus eventBus) {
		this.view.reset();
		panel.setWidget(this.view);

	}

	public void doSearch(ClickEvent e) {
		String str = this.view.getCode();
		String[] codes = str.split("\\s+");
		
		
		if (str.length() <= 3) {
			clientFactory.sendFlashMessage("code trop court");
			return;
		}
		
		GWT.log(str);
		
		this.view.prepareForSearching();
		
		
		
		
		
	}
	
	

}
