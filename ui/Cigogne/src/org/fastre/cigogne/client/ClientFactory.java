/**
 * 
 */
package org.fastre.cigogne.client;


import org.fastre.cigogne.client.model.repository.ListingRepository;
import org.fastre.cigogne.client.view.HomePageView;

import com.google.gwt.place.shared.PlaceController;
import com.google.gwt.user.client.Window;
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
    
    //repositories
    private final ListingRepository listingRepository = new ListingRepository(); 
   
    

	
	public EventBus getEventBus()
	{
		return this.eventBus;
	}
	
	public void sendFlashMessage(String message) {
		Window.alert(message);
	}


	/**
	 * @return the listingRepository
	 */
	public ListingRepository getListingRepository() {
		return listingRepository;
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
