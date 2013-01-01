/**
 * 
 */
package org.fastre.cigogne.client;


import org.fastre.cigogne.client.view.HomePageView;

import com.google.gwt.place.shared.PlaceController;
import com.google.web.bindery.event.shared.EventBus;
import com.google.web.bindery.event.shared.SimpleEventBus;

/**
 * @author Julien Fastré
 *
 */
public class ClientFactory {
	
	private final EventBus eventBus = new SimpleEventBus();
    private final PlaceController placeController = new PlaceController(eventBus);
    
    //views
    private final HomePageView homePage = new HomePageView();

	
	public EventBus getEventBus()
	{
		return this.eventBus;
	}


	public PlaceController getPlaceController() {
		return placeController;
	}


	/**
	 * @return the homePage
	 */
	public HomePageView getHomePage() {
		return homePage;
	}
	
	
	
}
