/**
 * 
 */
package org.fastre.cigogne.client;

import org.fastre.cigogne.client.event.HomePageEvent;
import org.fastre.cigogne.client.event.HomePageEventHandler;

import com.google.gwt.event.logical.shared.ValueChangeEvent;
import com.google.gwt.event.logical.shared.ValueChangeHandler;
import com.google.gwt.event.shared.HandlerManager;
import com.google.gwt.user.client.History;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.HasWidgets;

/**
 * @author Julien Fastré julien at fastre dot info
 *
 */
public class AppController implements ValueChangeHandler<String> {
	
	private HandlerManager eventBus;
	private HasWidgets container;

	public AppController(HandlerManager eventBus) {
		this.eventBus = eventBus;
		bind();
	}

	private void bind() {
		History.addValueChangeHandler(this);
		
		eventBus.addHandler(HomePageEvent.TYPE, 
				new HomePageEventHandler() {

					public void onHomePage(HomePageEvent event) {
						doShowHomePage();	
					}
			
		});
		
	}
	
	public void go(final HasWidgets container) {
		this.container = container;
		
		if ("".equals(History.getToken())) {
			History.newItem("home");
		} 
		else {
			History.fireCurrentHistoryState();
		}
		
	}

	/* (non-Javadoc)
	 * @see com.google.gwt.event.logical.shared.ValueChangeHandler#onValueChange(com.google.gwt.event.logical.shared.ValueChangeEvent)
	 */
	public void onValueChange(ValueChangeEvent<String> event) {
		String token = event.getValue();
		
		if (token != null) {
			
			if (token.equals("home")) {
				Window.alert("hello");
			}
			
			
		}

	}
	
	public void doShowHomePage() {
		History.newItem("home");
	}

}
